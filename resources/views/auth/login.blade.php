<x-guest-layout>
    <!-- Session Status -->
    <style>
        body {
            background-color: #dbe3dc;
            font-family: "Tahoma", sans-serif;
        }

        .login-card {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            background-color: #ffffff;
            text-align: center;
        }

        .login-header img {
            width: 100%;
            height: auto;
        }

        .login-body {
            background-color: #1e5e57;
            color: #fff;
            padding: 25px;
            text-align: center;
        }

        .login-body h4 {
            font-weight: bold;
        }

        .form-control {
            border-radius: 6px;
        }

        .btn-login {
            background-color: #fff;
            color: #1e5e57;
            font-weight: bold;
            border-radius: 6px;
        }

        .btn-login:hover {
            background-color: #e6e6e6;
        }

        .login-footer {
            background-color: #1e5e57;
            text-align: center;
            padding-bottom: 15px;
        }

        .login-footer a {
            color: white;
            font-size: 0.9rem;
            text-decoration: none;
        }
    </style>
    <div class="login-card">
        <!-- صورة -->
        <div class="login-header">
            <img src="{{ asset('assets/img/bac.png') }}" alt="شعار">
        </div>
        <!-- المحتوى -->
        <div class="login-body">
            <h4>أهلاً بعودتك!</h4>
            <p class="mb-4">سجل دخولك لإدارة بياناتك التطوعية والتعليمية</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3 text-start">
                    <label for="email" class="form-label text-white">البريد الجامعي</label>
                    <input type="text" class="form-control" id="email" name="email"
                        placeholder="example@domain.com" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-3 text-start">
                    <label for="password" class="form-label text-white">كلمة المرور</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••"
                        required>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="d-flex mb-3 form-check text-start">
                    <label class="form-check-label text-white" for="remember">تذكرني</label>
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                </div>
                <button type="submit" class="btn btn-login w-100">تسجيل الدخول</button>
            </form>
        </div>
        <!-- الفوتر -->
        <div class="login-footer">
            <p style="color: white;">
                <a href="#">هل نسيت كلمة المرور؟</a> |
                <a href="{{ route('register') }}">إنشاء حساب جديد</a>
            </p>
        </div>
    </div>





    <!-- Footer Links -->
    {{-- <div class="login-footer text-center mt-4">
        <p class="text-white">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="underline hover:text-gray-300">هل نسيت كلمة المرور؟</a>
            @endif
            |
            <a href="{{ route('register') }}" class="underline hover:text-gray-300">إنشاء حساب جديد</a>
        </p>
    </div> --}}
</x-guest-layout>
