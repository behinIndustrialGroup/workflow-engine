<div class="container-fluid">
    <h5 class="mb-3">ثبت پرداخت برای پرونده {{ $onCredit->case_number }}</h5>
    <form method="POST" action="{{ route('simpleWorkflowReport.on-credit-report.update', $onCredit->id) }}">
        @csrf
        @method('PATCH')
        <table class="table" id="payment-rows">
            <thead>
                <tr>
                    <th>نوع پرداخت</th>
                    <th>جزئیات</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <button type="button" class="btn btn-secondary btn-sm" id="add-payment">افزودن ردیف پرداخت</button>
        <div class="text-right mt-3">
            <button type="submit" class="btn btn-primary">ذخیره</button>
        </div>
    </form>

    @if($payments->count())
        <hr>
        <h6>پرداخت های ثبت شده</h6>
        <ul class="list-group">
            @foreach($payments as $payment)
                <li class="list-group-item">{{ $payment->payment_method }} - {{ number_format($payment->payment) }}</li>
            @endforeach
        </ul>
    @endif
</div>

<script>
    let rowIndex = 0;
    function addRow(){
        const row = `
            <tr>
                <td>
                    <select name="payments[${rowIndex}][type]" class="form-control payment-type">
                        <option value="cash">نقدی</option>
                        <option value="cheque">چک</option>
                        <option value="invoice">فاکتور</option>
                    </select>
                </td>
                <td>
                    <div class="cash-fields payment-field-group">
                        <input type="text" name="payments[${rowIndex}][amount]" class="form-control mb-1" placeholder="مبلغ پرداختی">
                        <input type="text" name="payments[${rowIndex}][date]" class="form-control mb-1 persian-date" placeholder="تاریخ پرداخت">
                        <input type="text" name="payments[${rowIndex}][account_number]" class="form-control mb-1" placeholder="شماره مقصد حساب">
                        <input type="text" name="payments[${rowIndex}][account_name]" class="form-control mb-1" placeholder="نام مقصد حساب">
                    </div>
                    <div class="cheque-fields payment-field-group d-none">
                        <input type="text" name="payments[${rowIndex}][amount]" class="form-control mb-1" placeholder="مبلغ چک">
                        <input type="text" name="payments[${rowIndex}][date]" class="form-control mb-1 persian-date" placeholder="تاریخ سررسید چک">
                        <input type="text" name="payments[${rowIndex}][cheque_number]" class="form-control mb-1" placeholder="شماره چک">
                        <input type="text" name="payments[${rowIndex}][bank_name]" class="form-control mb-1" placeholder="نام بانک">
                    </div>
                    <div class="invoice-fields payment-field-group d-none">
                        <input type="text" name="payments[${rowIndex}][amount]" class="form-control mb-1" placeholder="مبلغ فاکتور">
                        <input type="text" name="payments[${rowIndex}][date]" class="form-control mb-1 persian-date" placeholder="تاریخ فاکتور">
                        <input type="text" name="payments[${rowIndex}][invoice_number]" class="form-control mb-1" placeholder="شماره فاکتور">
                    </div>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">&times;</button></td>
            </tr>`;
        const $row = $(row);
        $row.find('.payment-type').on('change', function(){
            const type = $(this).val();
            $row.find('.payment-field-group').addClass('d-none');
            if(type === 'cash'){ $row.find('.cash-fields').removeClass('d-none'); }
            if(type === 'cheque'){ $row.find('.cheque-fields').removeClass('d-none'); }
            if(type === 'invoice'){ $row.find('.invoice-fields').removeClass('d-none'); }
        });
        $row.find('.remove-row').on('click', function(){ $row.remove(); });
        $('#payment-rows tbody').append($row);
        $('.persian-date').persianDatepicker({
            viewMode: 'day',
            initialValue: false,
            format: 'YYYY-MM-DD',
            initialValueType: 'persian'
        });
        rowIndex++;
    }
    $('#add-payment').on('click', addRow);
    addRow();
</script>
