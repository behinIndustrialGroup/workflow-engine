<?php

namespace BehinProcessMakerAdmin\Controllers;

use App\Http\Controllers\Controller;
use BehinProcessMaker\Controllers\AuthController;
use BehinProcessMaker\Controllers\CaseController;
use BehinProcessMaker\Controllers\CaseTrackerController;
use BehinProcessMaker\Controllers\CurlRequestController;
use BehinProcessMaker\Controllers\GetCaseVarsController;
use BehinProcessMaker\Controllers\GetTaskAsigneeController;
use BehinProcessMaker\Controllers\TaskController;
use BehinProcessMaker\Models\PmVars;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CaseHistoryController extends Controller
{
    public static function get($caseHistory){
        
        // return $caseHistory;
        $data = [];
        $i=0;
        foreach($caseHistory as $history){
            foreach($history->delegations as $historyDelegation){
                $data[$i]['task_uid'] = $history->tas_uid;
                $data[$i]['tas_title'] = $history->tas_title;
                $data[$i]['status'] = $history->status;
                $data[$i]['tas_type'] = $history->tas_type;
                $data[$i]['del_index'] = (int)$historyDelegation?->del_index;
                $data[$i]['del_init_date'] = $historyDelegation?->del_init_date;
                $data[$i]['del_finish_date'] = $historyDelegation?->del_finish_date;
                $data[$i]['del_duration'] = $historyDelegation?->del_duration;
                $data[$i]['del_task_due_date'] = $historyDelegation?->del_task_due_date;
                $data[$i]['tas_derivation'] = $history?->tas_derivation;
                $data[$i]['usr_firstname'] = $historyDelegation->usr_firstname;
                $data[$i]['usr_lastname'] = $historyDelegation->usr_lastname;
                $data[$i]['usr_uid'] = $historyDelegation->usr_uid;
                $data[$i]['tas_uid'] = $history->tas_uid;
                $i++;
            }
        }
        $dels = array_column($data, 'del_index');
        array_multisort($dels, SORT_DESC, $data);
        return collect($data)->groupBy('del_index')->toArray();
        return $data;

    }

    public static function caseHistoryForm(Request $r){
        $caseHistory = TaskController::getCaseTasks($r->caseId);
        if(!$caseHistory){
            return response(trans("there is a issue on this case"), 300);
        }
        return view('PMAdminViews::case-history')->with([
            'data' => self::get($caseHistory)
        ]);
    }
}