@extends('behin-layouts.app')

@section('title')
    {{ trans('fields.Edit Records') }}
@endsection

@section('content')
<div class="container card p-3 table-responsive">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-strpped" id="recordsTable">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th class="text-left">{{ trans('fields.' . $column) }}</th>
                @endforeach
                <th>{{ trans('fields.Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                @foreach($columns as $column)
                    <td class="text-left">{{ $record->$column }}</td>
                @endforeach
                <td>
                    <a href="{{ route('simpleWorkflow.entities.editRecord', [$entity->id, $record->id]) }}">{{ trans('fields.Edit') }}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
    $('#recordsTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
        }
    });
</script>
@endsection
