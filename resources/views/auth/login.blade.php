@extends('behin-layouts.welcome')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        font-family: 'IRANSans', sans-serif;
    }

    .login-card {
        backdrop-filter: blur(15px);
        background: rgba(255, 255, 255, 0.85);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out;
    }
    .login-card:hover {
        transform: translateY(-5px);
    }

    .form-control {
        border: none;
        border-bottom: 2px solid #ccc;
        border-radius: 0;
        background: transparent;
        box-shadow: none !important;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-bottom: 2px solid #2575fc;
        outline: none;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border: none;
        color: #fff;
        font-weight: bold;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .btn-gradient:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37,117,252,0.3);
    }

    .floating-label {
        position: absolute;
        top: 12px;
        right: 10px;
        font-size: 14px;
        color: #777;
        transition: 0.3s;
        pointer-events: none;
    }
    .form-control:focus + .floating-label,
    .form-control:not(:placeholder-shown) + .floating-label {
        top: -8px;
        right: 0;
        font-size: 12px;
        color: #2575fc;
    }
</style>

<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card login-card p-4" style="max-width: 400px; width: 100%;">
        <!-- لوگو -->
        <div class="text-center mb-4">
            <img src="{{ url('public/behin/logo.png') . '?' . config('app.version') }}" class="img-fluid" style="max-height: 70px" alt="Logo">
        </div>

        <h4 class="text-center mb-4 fw-bold text-dark">ورود به حساب کاربری</h4>

        <form id="login-form" method="POST" action="javascript:void(0)" class="position-relative">
            @csrf
            <input type="hidden" name="remember" value="1">

            <!-- موبایل -->
            <div class="mb-4 position-relative">
                <input type="text" name="email" class="form-control" id="inputMobile" placeholder=" " required>
                <label for="inputMobile" class="floating-label"><i class="fa fa-phone me-1"></i> موبایل</label>
            </div>

            <!-- رمز عبور -->
            <div class="mb-4 position-relative">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder=" " required>
                <label for="inputPassword" class="floating-label"><i class="fa fa-lock me-1"></i> رمز عبور</label>
            </div>

            <!-- دکمه ورود -->
            <button type="submit" onclick="submitLogin()" class="btn btn-gradient w-100 py-3">
                ورود
            </button>
        </form>

        <!-- لینک‌ها -->
        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="d-block small text-decoration-none text-primary">ثبت نام</a>
            <a href="{{ route('password.request') }}" class="d-block small text-decoration-none text-primary mt-1">فراموشی رمز عبور</a>
        </div>

        <!-- اینماد -->
        <div class="mt-4 text-center">
            @include('auth.partial.enamad-and-version')
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    @if (auth()->id())
        show_message("شما قبلا وارد شده‌اید");
        show_message("به صفحه داشبورد منتقل می‌شوید");
        window.location = "{{ url('admin') }}";
    @endif

    function submitLogin() {
        send_ajax_request(
            "{{ route('login') }}",
            $('#login-form').serialize(),
            function(response) {
                show_message("به صفحه داشبورد منتقل می‌شوید");
                window.location = "{{ url('admin') }}";
            },
            function(response) {
                show_error(response);
                hide_loading();
            }
        )
    }
</script>
@endsection
