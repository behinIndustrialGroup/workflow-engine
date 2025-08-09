<?php

use Behin\SimpleWorkflow\Controllers\Core\ConditionController;
use Behin\SimpleWorkflow\Controllers\Core\FieldController;
use Behin\SimpleWorkflow\Controllers\Core\FormController;
use Behin\SimpleWorkflow\Controllers\Core\InboxController;
use Behin\SimpleWorkflow\Controllers\Core\RoutingController;
use Behin\SimpleWorkflow\Controllers\Core\ScriptController;
use Behin\SimpleWorkflow\Controllers\Core\TaskActorController;
use Behin\SimpleWorkflow\Controllers\Core\TaskController;
use Behin\SimpleWorkflow\Models\Core\Cases;
use Behin\SimpleWorkflow\Models\Core\Variable;
use Behin\SimpleWorkflowReport\Controllers\Core\ChequeReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\ExpiredController;
use Behin\SimpleWorkflowReport\Controllers\Core\ExternalAndInternalReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\FinReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\MapaCenterController;
use Behin\SimpleWorkflowReport\Controllers\Core\ProcessController;
use Behin\SimpleWorkflowReport\Controllers\Core\ReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\RoleReportFormController;
use Behin\SimpleWorkflowReport\Controllers\Core\SummaryReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\TimeoffController;
use Behin\SimpleWorkflowReport\Controllers\Core\CounterPartyController;
use Behin\SimpleWorkflowReport\Controllers\Core\CreditorReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\DailyReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\OnCreditReportController;
use Behin\SimpleWorkflowReport\Controllers\Core\PersonelActivityController;
use Behin\SimpleWorkflowReport\Controllers\Scripts\TotalTimeoff;
use Behin\SimpleWorkflowReport\Controllers\Scripts\UserTimeoffs;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::name('simpleWorkflowReport.')->prefix('workflow-report')->middleware(['web', 'auth'])->group(function () {
    Route::get('index', [ReportController::class, 'index'])->name('index');
    Route::resource('report', ReportController::class);
    Route::resource('summary-report', SummaryReportController::class);
    Route::resource('role', RoleReportFormController::class);
    Route::resource('fin-report', FinReportController::class);
    Route::resource('external-internal', ExternalAndInternalReportController::class);
    Route::post('external-internal/search', [ExternalAndInternalReportController::class, 'search'])->name('external-internal.search');
    Route::get('external-internal-archive', [ExternalAndInternalReportController::class, 'archive'])->name('external-internal-archive');

    Route::resource('counter-party', CounterPartyController::class);

    Route::name('fin.')->prefix('fin')->group(function(){
        Route::get('', [FinReportController::class, 'index'])->name('index');
        Route::get('total-cost', [FinReportController::class, 'totalCost'])->name('totalCost');
        Route::get('all-payments/{year?}/{month?}/{user?}', [FinReportController::class, 'allPayments'])->name('allPayments');
    });
    Route::get('total-payment', [FinReportController::class, 'totalPayment'])->name('totalPayment');
    Route::get('total-timeoff', function(){
        return Excel::download(new TotalTimeoff, 'total_timeoff.xlsx');
    })->name('totalTimeoff');

    Route::get('user-timeoffs/{userId?}', function($userId = null){
        return Excel::download(new UserTimeoffs($userId), 'timeoff_report.xlsx');
    })->name('userTimeoffs');

    Route::post('timeoff/update', [TimeoffController::class, 'update'])->name('timeoff.update');

    Route::resource('expired-tasks', ExpiredController::class);

    Route::name('process.')->prefix('process')->group(function(){
        Route::prefix('{processId}')->group(function(){
            Route::post('update', [ProcessController::class, 'update'])->name('update');
            Route::get('export', [ProcessController::class, 'export'])->name('export');
        });
    });


    Route::resource('mapa-center', MapaCenterController::class);
    Route::put('mapa-center/update-case-info/{mapa_center}', [MapaCenterController::class, 'updateCaseInfo'])->name('mapa-center.update-case-info');
    Route::post('mapa-center/exclude-device/{mapa_center}', [MapaCenterController::class, 'excludeDevice'])->name('mapa-center.exclude-device');
    Route::post('mapa-center/install-part/{mapa_center}', [MapaCenterController::class, 'installPart'])->name('mapa-center.install-part');
    Route::get('mapa-center/delete-install-part/{id}', [MapaCenterController::class, 'deleteInstallPart'])->name('mapa-center.delete-install-part');
    Route::get('mapa-center-archive', [MapaCenterController::class, 'archive'])->name('mapa-center-archive');

    Route::resource('cheque-report', ChequeReportController::class);
    Route::resource('on-credit-report', OnCreditReportController::class);
    Route::get('on-credit-report-show-all', [OnCreditReportController::class, 'showAll'])->name('on-credit-report.showAll');
    Route::resource('personel-activity', PersonelActivityController::class);
    Route::get('personel-activity/{user_id}/show-inboxes/{from?}/{to?}', [PersonelActivityController::class, 'showInboxes'])->name('personel-activity.showInboxes');
    Route::get('personel-activity/{user_id}/show-dones/{from?}/{to?}', [PersonelActivityController::class, 'showDones'])->name('personel-activity.showDones');

    Route::get('daily-report', [DailyReportController:: class, 'index'])->name('daily-report.index');
    Route::get('daily-report/{user_id}/show-internal/{from?}/{to?}', [DailyReportController:: class, 'showInternal'])->name('daily-report.show-internal');
    Route::get('daily-report/{user_id}/show-external/{from?}/{to?}', [DailyReportController:: class, 'showExternal'])->name('daily-report.show-external');
    Route::get('daily-report/{user_id}/show-mapa-center/{from?}/{to?}', [DailyReportController:: class, 'showMapaCenter'])->name('daily-report.show-mapa-center');
    Route::get('daily-report/{user_id}/show-external-as-assistant/{from?}/{to?}', [DailyReportController:: class, 'showExternalAsAssistant'])->name('daily-report.show-external-as-assistant');

    Route::resource('creditor', CreditorReportController::class);


});
