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
                    required autofocus>
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
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- التخصص --}}
        <div class="col-md-6">
            <label for="specialization_id" class="form-label fw-semibold">{{ __('التخصص الدقيق') }}</label>
            <select id="specialization_id" name="specialization_id"
                class="form-select @error('specialization_id') is-invalid @enderror" required>
                <option value="">{{ __('اختر التخصص الدقيق') }}</option>
                @foreach ($specializations as $specialization)
                    <option value="{{ $specialization->id }}"
                        {{ old('specialization_id', optional($user->student->specializ)->id ?? optional($user->supervisor)->specialization_id) == $specialization->id ? 'selected' : '' }}>
                        {{ $specialization->title }}
                    </option>
                @endforeach
            </select>
            @error('specialization_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 👨‍🎓 حقول خاصة بالطلاب --}}
        @if ($user->hasRole('student'))
            {{-- الجنس --}}
            <div class="col-md-6">
                <label for="gender" class="form-label fw-semibold">{{ __('الجنس') }}</label>
                <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror"
                    required>
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

            {{-- السنة الدراسية --}}
            <div class="col-md-6">
                <label for="year" class="form-label fw-semibold">{{ __('السنة الدراسية') }}</label>
                <select id="year" name="year" class="form-select @error('year') is-invalid @enderror" required>
                    <option value="">{{ __('اختر السنة') }}</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}"
                            {{ old('year', optional($user->student->yearRelation)->id ?? '') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
                @error('year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- المشرف الأكاديمي --}}
            <div class="col-md-6">
                <label for="supervisor_id" class="form-label fw-semibold">{{ __('المشرف الأكاديمي') }}</label>
                <select id="supervisor_id" name="supervisor_id"
                    class="form-select @error('supervisor_id') is-invalid @enderror" required>
                    <option value="">{{ __('اختر المشرف') }}</option>
                    @foreach ($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}"
                            {{ old('supervisor_id', optional($user->student->supervisor->first())->id ?? '') == $supervisor->id ? 'selected' : '' }}>
                            {{ $supervisor->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('supervisor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endif

        {{-- نبذة عن المستخدم --}}
        <div class="col-12">
            <label for="bio" class="form-label fw-semibold">{{ __('نبذة عنك') }}</label>
            <textarea id="bio" name="bio" rows="3" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->student->bio ?? ($user->supervisor->bio ?? '')) }}</textarea>
            @error('bio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- زر الحفظ --}}
        <div class="col-12 d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-save me-1"></i> {{ __('حفظ التغييرات') }}
            </button>
        </div>
    </form>
</section>
