<x-dash-layout>

    <h2 class="fw-bold mb-4 text-center">قائمة المحتويات المعلقة</h2>

    @if (session('status_message'))
        <!-- مودال إعلام التحديث -->
        <x-modal id="statusModal" title="تم التحديث" maxWidth="sm">
            <p>{{ session('status_message') }}</p>
            <div class="text-end mt-3">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </x-modal>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                statusModal.show();
            });
        </script>
    @endif

    @forelse ($contents as $content)
        <div class="card mb-2 p-3 d-flex justify-content-between align-items-center">
            <div>
                <h5>{{ $content->title }}</h5>
                <p class="text-muted mb-1">{{ $content->description ?? '-' }}</p>
                <small>الفصل: {{ $content->chapter->title ?? '-' }}</small>
            </div>

            <div class="d-flex">
                {{-- عرض المحتوى --}}
                <button class="btn btn-sm btn-info me-2" data-bs-toggle="modal"
                    data-bs-target="#viewContentModal{{ $content->id }}">
                    <i class="fa-solid fa-eye"></i> عرض
                </button>

                {{-- زر إرسال ملخص --}}
                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal"
                    data-bs-target="#summaryContentModal{{ $content->id }}">
                    <i class="fa-solid fa-file-pen"></i> ملخص
                </button>

                {{-- تغيير الحالة --}}
                <form action="{{ route('supervisor.contents.updateStatus', $content->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                        <option value="approved" {{ $content->status == 'approved' ? 'selected' : '' }}>اعتماد</option>
                        <option value="rejected" {{ $content->status == 'rejected' ? 'selected' : '' }}>رفض</option>
                        <option value="pending" {{ $content->status == 'pending' ? 'selected' : '' }}>معلق</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- مودال عرض المحتوى --}}
        <x-modal id="viewContentModal{{ $content->id }}" title="تفاصيل المحتوى" maxWidth="lg">
            <h5>{{ $content->title }}</h5>
            <p>{{ $content->description ?? '-' }}</p>
            @if ($content->file)
                <a href="{{ asset('storage/' . $content->file) }}" target="_blank" class="btn btn-primary">
                    <i class="fa-solid fa-file-arrow-down me-1"></i> تحميل الملف
                </a>
            @endif
        </x-modal>

        {{-- مودال إرسال بلاغ --}}


        {{-- مودال إرسال ملخص --}}
        <x-modal id="summaryContentModal{{ $content->id }}" title="إرسال ملخص للمحتوى" maxWidth="md">
            <form action="{{ route('supervisor. content-summaries.store') }}" method="POST">
                @csrf
                <input type="hidden" name="content_id" value="{{ $content->id }}">

                <div class="mb-3">
                    <label for="type{{ $content->id }}" class="form-label">نوع الملخص</label>
                    <select name="type" id="type{{ $content->id }}" class="form-select" required>
                        <option value="">اختر النوع</option>
                        <option value="suggestion">اقتراح</option>
                        <option value="revision">تعديل مطلوب</option>
                        <option value="note">ملاحظات</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="notes{{ $content->id }}" class="form-label">الملخص / الملاحظات</label>
                    <textarea name="notes" id="notes{{ $content->id }}" rows="3" class="form-control"></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-paper-plane"></i> إرسال الملخص
                    </button>
                </div>
            </form>
        </x-modal>

    @empty
        <p class="text-muted text-center">لا يوجد محتوى لعرضه</p>
    @endforelse

</x-dash-layout>
