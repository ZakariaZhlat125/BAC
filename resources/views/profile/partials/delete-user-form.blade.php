<section class="card shadow-sm p-4">
    <header class="mb-3">
        <h2 class="h5 text-danger">
            {{ __('حذف الحساب') }}
        </h2>
        <p class="text-muted small mb-0">
            {{ __('بمجرد حذف حسابك، سيتم حذف جميع البيانات والموارد المرتبطة به بشكل نهائي. قبل حذف الحساب، يرجى تنزيل أي بيانات أو معلومات ترغب بالاحتفاظ بها.') }}
        </p>
    </header>

    <!-- زر الفتح -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        {{ __('حذف الحساب') }}
    </button>

    <!-- النافذة المنبثقة -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="confirmUserDeletionLabel">
                            {{ __('هل أنت متأكد أنك تريد حذف حسابك؟') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('إغلاق') }}"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted small">
                            {{ __('بمجرد حذف حسابك، سيتم حذف جميع البيانات والموارد المرتبطة به بشكل نهائي. يرجى إدخال كلمة المرور لتأكيد رغبتك في الحذف الدائم.') }}
                        </p>

                        {{-- كلمة المرور --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('كلمة المرور') }}</label>
                            <input id="password" name="password" type="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   placeholder="{{ __('كلمة المرور') }}" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('إلغاء') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ __('حذف الحساب') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
