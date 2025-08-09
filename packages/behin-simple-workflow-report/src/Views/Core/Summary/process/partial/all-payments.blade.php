@extends('behin-layouts.app')


@section('title')
    گزارش مالی
@endsection

@php
    use Behin\SimpleWorkflowReport\Controllers\Core\FinReportController;
    use Illuminate\Support\Carbon;
    use Morilog\Jalali\Jalalian;
    use Behin\SimpleWorkflowReport\Helper\ReportHelper;

    $today = Carbon::today();
    $todayShamsi = Jalalian::fromCarbon($today);
    $thisYear = $todayShamsi->getYear();
    $thisMonth = $todayShamsi->getMonth();
    $thisMonth = str_pad($thisMonth, 2, '0', STR_PAD_LEFT);
    $to = Jalalian::fromFormat('Y-m-d', "$thisYear-$thisMonth-01")
        ->addMonths(1)
        ->subDays(1)
        ->format('Y-m-d');

    $from = isset($_GET['from']) ? $_GET['from'] : "$thisYear-$thisMonth-01";
    $to = isset($_GET['to']) ? $_GET['to'] : (string) $to;
    $user = isset($_GET['user']) ? $_GET['user'] : null;
    // dd(json_encode($rows['destinations']));
@endphp

@section('content')
    <div class="card">
        <div class="card-header  text-center bg-info">
            جستجو
        </div>
        <div class="card-body">
            <form action="{{ url()->current() }}" class="form-row align-items-end">

                <div class="form-group col-md-2">
                    <label for="year">از</label>
                    <input type="text" name="from" value="{{ $from }}" class="form-control persian-date">
                </div>
                <div class="form-group col-md-2">
                    <label for="year">تا</label>
                    <input type="text" name="to" value="{{ $to }}" class="form-control persian-date">
                </div>

                <div class="form-group col-md-3">
                    <label for="user">مقصد حساب</label>
                    <select name="user" id="user" class="form-control select2">
                        <option value="">{{ trans('fields.All') }}</option>
                        @foreach ($rows['destinations'] as $key => $destination)
                            <option value="{{ $key }}" {{ $key == $user ? 'selected' : '' }}>{{ $key }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary btn-block">فیلتر</button>
                </div>

            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header  text-center bg-info">
            <h3 class="card-title">گزارش کل دریافت هزینه ها</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="total-cost" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('fields.Process') }}</th>
                            <th>{{ trans('fields.Case Number') }}</th>
                            <th>{{ trans('fields.Customer') }}</th>
                            <th>{{ trans('fields.Fix Cost Date') }}</th>
                            <th class="d-none">{{ trans('fields.Cost Amount') }}</th>
                            <th>{{ trans('fields.Payment Date') }}</th>
                            <th>{{ trans('fields.Payment Amount') }}</th>
                            <th>{{ trans('fields.Destination Account Name') }}</th>
                            <th>{{ trans('fields.Destination Account Number') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $numberOfInternalProcess = 0;
                            $numberOfExternalProcess = 0;
                            $rowNumber = 1;
                            $totalPayment = 0;
                        @endphp
                        @foreach ($rows['rows'] as $row)
                            <tr>
                                <td>{{ $rowNumber++ }}</td>
                                <td>{{ $row->process_name }}
                                    @php
                                        if ($row->process_name == 'داخلی') {
                                            $numberOfInternalProcess += 1;
                                        }
                                        if ($row->process_name == 'خارجی') {
                                            $numberOfExternalProcess += 1;
                                        }
                                    @endphp
                                </td>
                                <td>{{ $row->case_number }}
                                    <a
                                        href="{{ route('simpleWorkflowReport.external-internal.show', ['external_internal' => $row->case_number]) }}"><i
                                            class="fa fa-external-link"></i></a>
                                </td>
                                <td>{{ $row->case()->getVariable('customer_workshop_or_ceo_name') }}</td>
                                <td>{{ $row->fix_cost_date ? toJalali((int) $row->fix_cost_date)->format('Y-m-d') : '' }}
                                </td>
                                <td class="d-none">{{ number_format((int)$row->cost) }}</td>
                                <td>{{ $row->payment_date ? toJalali((int) $row->payment_date)->format('Y-m-d') : '' }}</td>
                                <td>{{ number_format((int)$row->payment) }}
                                    @php
                                        $totalPayment += (int)$row->payment;
                                    @endphp
                                </td>
                                <td>{{ $row->destination_account_name }}</td>
                                <td>{{ $row->destination_account }}</td>
                            </tr>
                            @if($row->cost2)
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $row->process_name }}
                                        @php
                                            if ($row->process_name == 'داخلی') {
                                                $numberOfInternalProcess += 1;
                                            }
                                            if ($row->process_name == 'خارجی') {
                                                $numberOfExternalProcess += 1;
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $row->case_number }}
                                        <a
                                            href="{{ route('simpleWorkflowReport.external-internal.show', ['external_internal' => $row->case_number]) }}"><i
                                                class="fa fa-external-link"></i></a>
                                    </td>
                                    <td>{{ $row->case()->getVariable('customer_workshop_or_ceo_name') }}</td>
                                    <td>{{ $row->fix_cost_date ? toJalali((int) $row->fix_cost_date)->format('Y-m-d') : '' }}
                                    </td>
                                    <td class="d-none">{{ number_format((int)$row->cost2) }}</td>
                                    <td>{{ $row->payment_date ? toJalali((int) $row->payment_date)->format('Y-m-d') : '' }}</td>
                                    <td>{{ number_format((int)$row->payment) }}</td>
                                    <td>{{ $row->destination_account_name_2 }}</td>
                                    <td>{{ $row->destination_account_2 }}</td>
                                </tr>
                            @endif
                            @if($row->cost3)
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $row->process_name }}
                                        @php
                                            if ($row->process_name == 'داخلی') {
                                                $numberOfInternalProcess += 1;
                                            }
                                            if ($row->process_name == 'خارجی') {
                                                $numberOfExternalProcess += 1;
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $row->case_number }}
                                        <a
                                            href="{{ route('simpleWorkflowReport.external-internal.show', ['external_internal' => $row->case_number]) }}"><i
                                                class="fa fa-external-link"></i></a>
                                    </td>
                                    <td>{{ $row->case()->getVariable('customer_workshop_or_ceo_name') }}</td>
                                    <td>{{ $row->fix_cost_date ? toJalali((int) $row->fix_cost_date)->format('Y-m-d') : '' }}
                                    </td>
                                    <td class="d-none">{{ number_format((int)$row->cost3) }}</td>
                                    <td>{{ $row->payment_date ? toJalali((int) $row->payment_date)->format('Y-m-d') : '' }}</td>
                                    <td>{{ number_format((int)$row->payment) }}</td>
                                    <td>{{ $row->destination_account_name_3 }}</td>
                                    <td>{{ $row->destination_account_3 }}</td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th colspan="2"></th>
                            <th colspan="2" style="text-align:right">جمع این صفحه:</th>
                            <th id="total-payment"></th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer bg-secondary">
                <div class="row">
                    <div class="col-md-6">
                        مجموع کل: {{ number_format($totalPayment) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        initial_view();
        $(document).ready(function() {
            $('#total-cost').DataTable({
                "dom": 'Bfrtip',
                "buttons": [{
                    "extend": 'excelHtml5',
                    "text": "خروجی اکسل",
                    "title": "گزارش مجموع هزینه های دریافت شده به ازای کارشناس",
                    "className": "btn btn-success btn-sm",
                    "exportOptions": {
                        "columns": ':visible',
                        "footer": true
                    }
                }, ],

                "pageLength": -1,
                "order": [
                    [5, "desc"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // تابع تبدیل به عدد
                    var intVal = function(i) {
                        if (typeof i === 'string') {
                            return parseInt(i.replace(/,/g, '')) || 0;
                        }
                        return typeof i === 'number' ? i : 0;
                    };

                    // مجموع فقط در صفحه فعلی (و فیلترشده)
                    var pageTotal = api
                        .column(7, {
                            page: 'current'
                        }) // ستون مبلغ
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // نمایش در فوتر
                    $(api.column(6).footer()).html(
                        pageTotal.toLocaleString('fa-IR') + ' ریال'
                    );
                }
            });
            $('#mapa-expert').DataTable({
                "dom": 'Bfrtip',
                "buttons": [{
                    "extend": 'excelHtml5',
                    "text": "خروجی اکسل",
                    "title": "گزارش مجموع هزینه های دریافت شده به ازای کارشناس",
                    "className": "btn btn-success btn-sm",
                    "exportOptions": {
                        "columns": ':visible',
                        "footer": true
                    }
                }, ],
                "searching": false,
                "pageLength": -1,
                "order": [
                    [0, "asc"]
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Persian.json"
                },
            });
        });
    </script>
@endsection
