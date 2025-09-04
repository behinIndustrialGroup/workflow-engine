<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflowReport\Controllers\Scripts\PettyCashExport;
use Behin\SimpleWorkflowReport\Models\PettyCash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class PettyCashController extends Controller
{
    public function index(Request $request)
    {
        $query = PettyCash::query();
        if ($request->filled('from')) {
            $from = Jalalian::fromFormat('Y-m-d', $request->input('from'))
                ->toCarbon()
                ->startOfDay()
                ->timestamp;
            $query->where('paid_at', '>=', $from);
        }
        if ($request->filled('to')) {
            $to = Jalalian::fromFormat('Y-m-d', $request->input('to'))
                ->toCarbon()
                ->endOfDay()
                ->timestamp;
            $query->where('paid_at', '<=', $to);
        }
        $pettyCashes = $query->orderByDesc('paid_at')->get();
        return view('SimpleWorkflowReportView::Core.PettyCash.index', compact('pettyCashes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'paid_at' => 'required|string',
            'from_account' => 'nullable|string',
        ]);
        $data['paid_at'] = convertPersianToEnglish($data['paid_at']);
        $data['paid_at'] = Jalalian::fromFormat('Y-m-d', $data['paid_at'])
            ->toCarbon()
            ->timestamp;
        return $data;

        PettyCash::create($data);
        return redirect()->back()->with('success', 'با موفقیت ذخیره شد.');
    }

    public function edit(PettyCash $pettyCash)
    {
        return view('SimpleWorkflowReportView::Core.PettyCash.edit', compact('pettyCash'));
    }

    public function update(Request $request, PettyCash $pettyCash)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'paid_at' => 'required|string',
            'from_account' => 'nullable|string',
        ]);
        $data['paid_at'] = Jalalian::fromFormat('Y-m-d', $data['paid_at'])
            ->toCarbon()
            ->timestamp;
        $pettyCash->update($data);
        return redirect()->route('simpleWorkflowReport.petty-cash.index')->with('success', 'با موفقیت ذخیره شد.');
    }

    public function destroy(PettyCash $pettyCash)
    {
        $pettyCash->delete();
        return redirect()->back()->with('success', 'با موفقیت حذف شد.');
    }

    public function export(Request $request)
    {
        return Excel::download(new PettyCashExport($request->input('from'), $request->input('to')), 'petty_cash.xlsx');
    }
}

