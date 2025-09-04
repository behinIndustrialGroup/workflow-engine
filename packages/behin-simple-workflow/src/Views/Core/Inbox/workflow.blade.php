@extends('behin-layouts.app')

@section('title')
    {{ trans('fields.Workflow') }}
@endsection

@section('content')
    <style>
        .task-form  {
            fill: #007bff !important;
            stroke: #0056b3 !important;
            font-family: Vazir !important;
            color: white !important;
        }
        .task-script  {
            fill: #28a745 !important;
            stroke: #1e7e34 !important;
            font-family: Vazir !important;
            color: white !important;
        }
        .task-condition  {
            fill: #ffc107 !important;
            stroke: #d39e00 !important;
            font-family: Vazir !important;
            color: white !important;
        }
        .task-end  {
            fill: #f10808 !important;
            stroke: #d30000 !important;
            font-family: Vazir !important;
            color: white !important;
        }
        .task-timed_condition  {
            fill: #8408f1 !important;
            stroke: #6d00d3 !important;
            font-family: Vazir !important;
            color: white !important;
        }
        .task-done{
            fill: #28a745 !important;
            stroke: #218838 !important;
            color: #fff !important;
        }
        .task-current{
            fill: #ffc107 !important;
            stroke: #e0a800 !important;
            color: #000 !important;
        }
    </style>
    <div class="container">
        <h3>گردش کار پرونده شماره {{ $case->number }}</h3>
        <div class="table-responsive">
            <div class="mermaid" style="width: 1000px">
                graph TD
                @foreach ($process->startTasks() as $task)
                    @php
                        $taskClass = 'task-' . $task->type;
                    @endphp
                    {{ $task->id }}["{{ $task->name }}"]:::{{ $taskClass }}
                    @if (in_array($task->id, $currentTasks))
                        class {{ $task->id }} task-current;
                    @elseif (in_array($task->id, $doneTasks))
                        class {{ $task->id }} task-done;
                    @endif
                    @php
                        $children = $task->children();
                    @endphp
                    @if (count($children))
                        @include('SimpleWorkflowView::Core.Inbox.workflow-tree', ['children' => $children, 'task' => $task, 'doneTasks' => $doneTasks, 'currentTasks' => $currentTasks])
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
