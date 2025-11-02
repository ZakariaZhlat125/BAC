<x-guest-layout>
    <style>
        body {
            background-color: #dbe3dc;
            font-family: "Tahoma", sans-serif;
        }

        .register-card {
            max-width: 500px;
            margin: auto;
            margin-top: 30px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            text-align: right;
            width: 100%;
        }

        .register-header {
            background-color: #1e5e57;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .register-body {
            padding: 25px;
            background-color: #1e5e57;
            color: white;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
            height: 45px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            font-size: 1rem;
        }

        .form-select {
            background: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .btn-register {
            background-color: #fff;
            color: #1e5e57;
            font-weight: bold;
            border-radius: 6px;
        }

        .btn-register:hover {
            background-color: #e6e6e6;
        }

        .register-footer {
            background-color: #1e5e57;
            text-align: center;
            padding: 15px;
        }

        .register-footer a {
            color: white;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .form-check-label {
            margin-right: 50px;
            width: 100%;
        }
    </style>

    <div class="container">
        <div class="register-card">
            <!-- الهيدر -->
            <div class="register-header">
                <h3>إنشاء حساب طالب جديد</h3>
            </div>

            <!-- المحتوى -->
            <div class="register-body">
                <form method="POST" action="{{ route('register_student') }}">
                    @csrf
                    <div class="mb-3 text-end">
                        <label for="name" class="form-label text-white">الاسم كامل</label>
                        <input type="text" class="form-control" name="name" id="name" required
                            placeholder="Ex: john Dun  ">
                        <small class="text-warning" dir="rtl">الرجاء إدخال الاسم ثلاثي (الاسم الأول - الأوسط -
                            الأخير)</small>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-3 text-end">
                        <label for="email" class="form-label text-white">البريد الجامعي</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            placeholder="123456789@student.kfu.edu.sa">
                        <small class="text-warning" dir="rtl">
                            يجب أن يبدأ بـ 9 احرف وينتهي بـ @student.kfu.edu.sa
                        </small>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>


                    <div class="mb-3 text-end">
                        <label for="password" class="form-label text-white">كلمة المرور</label>
                        <input type="password" class="form-control" name="password" id="password"
                            required><x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-3 text-end">
                        <label for="password_confirmation" class="form-label text-white">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" required>
                    </div>
                    <div class="mb-3 text-end">
                        <label for="bio" class="form-label text-white">نبذة</label>
                        <textarea type="text" class="form-control" name="bio" id="bio" required></textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <div class="mb-3 text-end">
                        <label for="gender" class="form-label text-white">الجنس</label>
                        <select class="form-control" name="gender" id="gender" required><x-input-error
                                :messages="$errors->get('gender')" class="mt-2" />
                            <option value="" disabled selected>اختر الجنس</option>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </div>

                    <div class="mb-3 text-end">
                        <label for="specialization_id" class="form-label text-white">التخصص</label>
                        <select class="form-control" name="specialization_id" id="specialization_id" required>
                            <option value="" disabled selected>اختر التخصص</option>
                            @foreach ($specializations as $specialization)
                                <option value="{{ $specialization->id }}">{{ $specialization->title }}</option>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 text-end">
                        <label for="year" class="form-label text-white">السنة الدراسية</label>
                        <select class="form-control" name="year" id="year" required>
                            <option value="" disabled selected>اختر السنة</option>
                            <option value="1">الأولى</option>
                            <option value="2">الثانية</option>
                            <option value="3">الثالثة</option>
                            <option value="4">الرابعة</option>
                        </select><x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-3 form-check text-end">
                        <input type="checkbox" class="form-check-input ms-2" name="agree" id="agree" required>
                        <label class="form-check-label text-white" for="agree">
                            أقر أن كافة المحتويات التي أنشرها صحيحة وأتحمل المسؤولية الكاملة عنها
                        </label>
                    </div>

                    <button type="submit" class="btn btn-register w-100">إنشاء الحساب</button>
                </form>
            </div>


            <!-- الفوتر -->
            <div class="register-footer">
                <p>
                    <a href="{{ route('login') }}">لديك حساب؟ تسجيل دخول</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
