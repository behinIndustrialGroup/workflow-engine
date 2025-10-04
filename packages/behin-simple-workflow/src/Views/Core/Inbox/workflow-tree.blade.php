@foreach ($children as $child)
    @php
        $taskClass = 'task-' . $child->type;
    @endphp
    {{ $task->id }} --> {{ $child->id }}["{{ $child->name }}"]:::{{ $taskClass }}
    @if (in_array($child->id, $currentTasks))
        class {{ $child->id }} task-current;
    @elseif (in_array($child->id, $doneTasks))
        class {{ $child->id }} task-done;
    @endif
    @php
        $grandChildren = $child->children();
    @endphp
    @if ($child->next_element_id)
        {{ $child->id }} --> {{ $child->next_element_id }}
    @endif
    @if (count($grandChildren))
        @include('SimpleWorkflowView::Core.Inbox.workflow-tree', ['children' => $grandChildren, 'task' => $child, 'doneTasks' => $doneTasks, 'currentTasks' => $currentTasks])
    @endif
@endforeach
