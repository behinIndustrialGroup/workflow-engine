@extends('behin-layouts.app')

@section('title', 'گزارش اقدامات پرسنل')
@php
    use Morilog\Jalali\Jalalian;

    $todayJalali = Jalalian::now()->format('Y-m-d');
    $fromDate = request('from_date') ?? $todayJalali;
    $toDate = request('to_date') ?? $todayJalali;
@endphp


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('simpleWorkflowReport.personel-activity.index') }}" class="mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label for="from_date">از تاریخ</label>
                            <input type="text" id="from_date" name="from_date" class="form-control persian-date" value="{{ $fromDate }}" placeholder="">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date">تا تاریخ</label>
                            <input type="text" id="to_date" name="to_date" class="form-control persian-date" value="{{ $toDate }}" placeholder="">
                        </div>
                        <div class="col-md-3">
                            <label for="user_id">پرسنل</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">همه پرسنل</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">فیلتر</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="card-body">
                <div class="col-sm-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>شماره</th>
                                <th>نام</th>
                                <th>در دست اقدام</th>
                                <th>انجام داده</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->number }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <i class="fa fa-external-link text-primary" onclick="showInboxes(`{{ $user->id }}`, `{{ $fromDate }}`, `{{ $toDate }}`)"></i>
                                        {{ $user->inbox }}</td>
                                    <td>
                                        <i class="fa fa-external-link text-primary" onclick="showDones(`{{ $user->id }}`, `{{ $fromDate }}`, `{{ $toDate }}`)"></i>
                                        {{ $user->done }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        initial_view()
        function showInboxes(userId, from = '', to = ''){
            url = "{{ route('simpleWorkflowReport.personel-activity.showInboxes', ['user_id', 'from', 'to']) }}";
            url = url.replace('user_id', userId)
            url = url.replace('from', from)
            url = url.replace('to', to)
            open_admin_modal(url);
        }

        function showDones(userId, from = '', to = ''){
            url = "{{ route('simpleWorkflowReport.personel-activity.showDones', ['user_id', 'from', 'to']) }}";
            url = url.replace('user_id', userId)
            url = url.replace('from', from)
            url = url.replace('to', to)
            open_admin_modal(url);
        }
    </script>
@endsection
