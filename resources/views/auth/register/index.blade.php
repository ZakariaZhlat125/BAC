<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
            font-family: "Tahoma", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 450px;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            text-align: center;
            padding: 30px 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        .login-header img {
            width: 120px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .login-header img:hover {
            transform: rotate(10deg);
        }

        .register-btn {
            display: block;
            width: 100%;
            margin: 15px 0;
            padding: 15px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-btn.student {
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .register-btn.student:hover {
            background: linear-gradient(90deg, #764ba2, #667eea);
            transform: scale(1.05);
        }

        .register-btn.supervisor {
            background: linear-gradient(90deg, #f7971e, #ffd200);
            color: #333;
        }

        .register-btn.supervisor:hover {
            background: linear-gradient(90deg, #ffd200, #f7971e);
            transform: scale(1.05);
        }
    </style>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('assets/img/bac.png') }}" alt="شعار">
            <h3>اختر نوع التسجيل</h3>
        </div>

        <!-- زر تسجيل الطالب -->
        <a href="{{ route('register.student') }}" class="register-btn student">
            تسجيل طالب
        </a>

        <!-- زر تسجيل المشرف -->
        <a href="{{ route('register.supervisor') }}" class="register-btn supervisor">
            تسجيل مشرف
        </a>
    </div>
</x-guest-layout>
