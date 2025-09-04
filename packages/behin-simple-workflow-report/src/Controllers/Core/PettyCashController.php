<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflowReport\Controllers\Scripts\PettyCashExport;
use Behin\SimpleWorkflowReport\Models\PettyCash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PettyCashController extends Controller
{
    public function index(Request $request)
    {
        $query = PettyCash::query();
        if ($request->filled('from')) {
            $query->whereDate('paid_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('paid_at', '<=', $request->input('to'));
        }
        $pettyCashes = $query->orderByDesc('paid_at')->get();
        return view('SimpleWorkflowReportView::Core.PettyCash.index', compact('pettyCashes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'paid_at' => 'required|date',
            'from_account' => 'nullable|string',
        ]);
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
            'paid_at' => 'required|date',
            'from_account' => 'nullable|string',
        ]);
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

