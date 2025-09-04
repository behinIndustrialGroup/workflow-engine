@extends('behin-layouts.app')

@section('title', 'گزارش تنخواه')
@php
    use Morilog\Jalali\Jalalian;
@endphp

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card mb-3">
        <div class="card-header">
            <form class="row" method="GET">
                <div class="col-md-3">
                    <input type="text" name="from" class="form-control persian-date" value="{{ request('from') }}" placeholder="از تاریخ">
                </div>
                <div class="col-md-3">
                    <input type="text" name="to" class="form-control persian-date" value="{{ request('to') }}" placeholder="تا تاریخ">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-secondary" type="submit">فیلتر</button>
                    <a href="{{ route('simpleWorkflowReport.petty-cash.export', ['from' => request('from'), 'to' => request('to')]) }}" class="btn btn-success">خروجی اکسل</a>
                </div>
            </form>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('simpleWorkflowReport.petty-cash.store') }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-3">
                    <input name="title" class="form-control" placeholder="عنوان خرج" required>
                </div>
                <div class="col-md-2">
                    <input name="amount" class="form-control formatted-digit" placeholder="مبلغ" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="paid_at" class="form-control persian-date" required>
                </div>
                <div class="col-md-3">
                    <input name="from_account" class="form-control" placeholder="از حساب">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">افزودن</button>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>عنوان خرج</th>
                        <th>مبلغ</th>
                        <th>تاریخ پرداخت</th>
                        <th>از حساب</th>
                        <th>اقدامات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pettyCashes as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ number_format($item->amount) }}</td>
                            <td>{{ Jalalian::forge($item->paid_at)->format('Y-m-d') }}</td>
                            <td>{{ $item->from_account }}</td>
                            <td>
                                <a href="{{ route('simpleWorkflowReport.petty-cash.edit', $item) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                <form action="{{ route('simpleWorkflowReport.petty-cash.destroy', $item) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('حذف شود؟')">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        initial_view();
    </script>
@endsection
