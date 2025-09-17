<section class="card border-0 shadow-lg rounded-3 p-4 bg-light">
    <header class="mb-4 border-bottom pb-2">
        <h2 class="h5 fw-bold text-primary mb-1">
            <i class="bi bi-person-circle me-2"></i>{{ __('معلومات الحساب') }}
        </h2>
        <p class="text-muted small mb-0">
            {{ __('قم بتحديث معلومات حسابك وعنوان البريد الإلكتروني.') }}
        </p>
    </header>

    {{-- نموذج مخفي لإعادة إرسال التحقق --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="row g-3">
        @csrf
        @method('patch')

        {{-- الاسم --}}
        <div class="col-md-6">
            <label for="name" class="form-label fw-semibold">{{ __('الاسم') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input id="name" name="name" type="text"
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}"
                    required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- البريد الإلكتروني --}}
        <div class="col-md-6">
            <label for="email" class="form-label fw-semibold">{{ __('البريد الإلكتروني') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input id="email" name="email" type="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                    required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small text-danger mb-1">
                        {{ __('عنوان بريدك الإلكتروني غير مفعل.') }}
                        <button form="send-verification" class="btn btn-sm btn-outline-primary ms-2">
                            {{ __('إعادة إرسال رابط التحقق') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="small text-success fw-semibold mb-0">
                            {{ __('تم إرسال رابط تحقق جديد.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- التخصص --}}
        {{-- <div class="col-md-6">
            <label for="major" class="form-label fw-semibold">{{ __('التخصص') }}</label>
            <input id="major" name="major" type="text"
                class="form-control @error('major') is-invalid @enderror"
                value="{{ old('major', $user->major ?? '') }}" maxlength="100">
            @error('major')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div> --}}

        {{-- الجنس --}}
        <div class="col-md-6">
            <label for="gender" class="form-label fw-semibold">{{ __('الجنس') }}</label>
            <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                <option value="">{{ __('اختر الجنس') }}</option>
                <option value="male" {{ old('gender', $user->gender ?? '') === 'male' ? 'selected' : '' }}>
                    {{ __('ذكر') }}
                </option>
                <option value="female" {{ old('gender', $user->gender ?? '') === 'female' ? 'selected' : '' }}>
                    {{ __('أنثى') }}
                </option>
            </select>
            @error('gender')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- التخصص الدقيق --}}
               <div class="col-md-6">
            <label for="specialization_id" class="form-label fw-semibold">{{ __('التخصص الدقيق') }}</label>

            <select id="specialization_id" name="specialization_id"
                class="form-select @error('specialization_id') is-invalid @enderror">
                <option value="">{{ __('اختر التخصص الدقيق') }}</option>
                @foreach ($specializations as $specialization)
                    <option value="{{ $specialization->id }}"
                        {{ old('specialization_id', $user->supervisor->specialization_id ?? '') == $specialization->id ? 'selected' : '' }}>
                        {{ $specialization->title }}
                    </option>
                @endforeach
            </select>
            @error('specialization_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- زر الحفظ --}}
        <div class="col-12 d-flex justify-content-end align-items-center mt-3">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-save me-1"></i> {{ __('حفظ التغييرات') }}
            </button>
            @if (session('status') === 'profile-updated')
                <span class="small text-success ms-3">{{ __('تم الحفظ.') }}</span>
            @endif
        </div>
    </form>
</section>
