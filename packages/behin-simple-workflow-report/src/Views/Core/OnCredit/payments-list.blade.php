<div>
    @if($payments->count())
        <hr>
        <h6 class="mb-3 text-center text-secondary">پرداخت‌های ثبت شده</h6>
        <ul class="list-group shadow-sm">
            @foreach($payments as $payment)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-primary">{{ $payment->payment_type }}</span>
                    <span class="badge bg-success rounded-pill">{{ number_format($payment->amount) }} ریال</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
