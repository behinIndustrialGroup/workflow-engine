<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflow\Controllers\Core\CaseController;
use Behin\SimpleWorkflow\Controllers\Core\FormController;
use Behin\SimpleWorkflow\Controllers\Core\InboxController;
use Behin\SimpleWorkflow\Controllers\Core\ProcessController;
use Behin\SimpleWorkflow\Controllers\Core\TaskController;
use Behin\SimpleWorkflow\Controllers\Core\VariableController;
use Behin\SimpleWorkflow\Models\Core\Inbox;
use Behin\SimpleWorkflow\Models\Core\Process;
use Behin\SimpleWorkflow\Models\Core\TaskActor;
use Behin\SimpleWorkflow\Models\Core\Variable;
use Behin\SimpleWorkflow\Models\Entities\Financials;
use Behin\SimpleWorkflowReport\Helper\ReportHelper;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class OnCreditReportController extends Controller
{
    public function index(Request $request)
    {
        $onCredits = Financials::whereNotNull('case_number')
            ->whereIn('fix_cost_type', ['حساب دفتری'])
            // ->whereNull('is_passed')
            ->get();
        return view('SimpleWorkflowReportView::Core.OnCredit.index', compact('onCredits'));
    }

    public function edit($id)
    {
        $onCredit = Financials::findOrFail($id);
        $payments = Financials::where('case_number', $onCredit->case_number)
            ->whereNotNull('payment')
            ->get();
        return view('SimpleWorkflowReportView::Core.OnCredit.edit', compact('onCredit', 'payments'));
    }

    public function update(Request $request, $id)
    {
        $onCredit = Financials::findOrFail($id);

        if ($request->has('is_passed')) {
            $onCredit->is_passed = true;
            $onCredit->save();
            return redirect()->back()->with('success', 'با موفقیت ذخیره شد.');
        }

        $payments = $request->input('payments', []);
        foreach ($payments as $payment) {
            if (!isset($payment['type']) || $payment['type'] === '') {
                continue;
            }

            $fin = new Financials();
            $fin->case_number = $onCredit->case_number;
            $fin->case_id = $onCredit->case_id;
            $fin->process_id = $onCredit->process_id;
            $fin->process_name = $onCredit->process_name;
            $fin->payment_method = $payment['type'];

            switch ($payment['type']) {
                case 'cash':
                    $fin->payment = isset($payment['amount']) ? str_replace(',', '', $payment['amount']) : null;
                    $fin->payment_date = !empty($payment['date']) ? convertPersianDateToTimestamp($payment['date']) : null;
                    $fin->destination_account = $payment['account_number'] ?? null;
                    $fin->destination_account_name = $payment['account_name'] ?? null;
                    break;
                case 'cheque':
                    $fin->cost = isset($payment['amount']) ? str_replace(',', '', $payment['amount']) : null;
                    $fin->cheque_due_date = !empty($payment['date']) ? convertPersianDateToTimestamp($payment['date']) : null;
                    $fin->cheque_number = $payment['cheque_number'] ?? null;
                    $fin->destination_account_name = $payment['bank_name'] ?? null;
                    break;
                case 'invoice':
                    $fin->cost = isset($payment['amount']) ? str_replace(',', '', $payment['amount']) : null;
                    $fin->fix_cost_date = !empty($payment['date']) ? convertPersianDateToTimestamp($payment['date']) : null;
                    $fin->description = $payment['invoice_number'] ?? null;
                    break;
            }

            $fin->save();
        }

        return redirect()->back()->with('success', 'با موفقیت ذخیره شد.');
    }

    public function showAll(Request $request)
    {
        $onCredits = Financials::whereNotNull('case_number')
            ->whereIn('fix_cost_type', ['حساب دفتری'])
            ->whereNull('is_passed')
            ->get();
        $inboxes = Inbox::whereIn('task_id', 
        ['adee777f-da9d-4d54-bf00-020a27e0f861', 
        'c008cd7d-ea9c-4b0b-917b-97e8ff651155', 
        '1c63c629-b27b-4fe6-a993-a7a149926c55']
        )->where('status', 'new')->get();
        return view('SimpleWorkflowReportView::Core.OnCredit.show-all', compact('onCredits', 'inboxes'));
    }
}
