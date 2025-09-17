<section class="card shadow-sm p-4">
    <header class="mb-3">
        <h2 class="h5 text-dark">
            {{ __('تحديث كلمة المرور') }}
        </h2>
        <p class="text-muted small mb-0">
            {{ __('تأكد من أن حسابك يستخدم كلمة مرور طويلة وعشوائية للحفاظ على أمانه.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        {{-- كلمة المرور الحالية --}}
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('كلمة المرور الحالية') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- كلمة المرور الجديدة --}}
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('كلمة المرور الجديدة') }}</label>
            <input id="update_password_password" name="password" type="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- تأكيد كلمة المرور --}}
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('تأكيد كلمة المرور') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- زر الحفظ --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                {{ __('حفظ') }}
            </button>

            @if (session('status') === 'password-updated')
                <p class="small text-success fw-semibold mb-0">
                    {{ __('تم الحفظ.') }}
                </p>
            @endif
        </div>
    </form>
</section>
