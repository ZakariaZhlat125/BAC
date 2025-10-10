<x-dash-layout>

    <style>
        body {
            background-color: #f8fafc;
        }

        .content-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 20px;
            background-color: #fff;
            transition: 0.3s;
        }

        .content-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .status-select {
            min-width: 140px;
        }

        .points-input {
            width: 90px;
        }

        .badge-status {
            font-size: 0.8rem;
            padding: 6px 10px;
        }

        .badge-status.approved {
            background-color: #198754;
        }

        .badge-status.pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-status.rejected {
            background-color: #dc3545;
        }
    </style>

    <h2 class="fw-bold mb-4 text-center text-primary">📚 قائمة المحتويات المعلقة</h2>

    @if (session('success'))
        <div class="alert alert-success text-center w-75 mx-auto">{{ session('success') }}</div>
    @endif

    @forelse ($contents as $content)
        <div class="content-card mb-3 d-flex justify-content-between align-items-start flex-wrap">

            {{-- معلومات المحتوى --}}
            <div class="flex-grow-1">
                <h5 class="fw-bold text-dark mb-1">{{ $content->title }}</h5>
                <p class="text-muted mb-1">{{ $content->description ?? '— لا يوجد وصف —' }}</p>
                <div>
                    <small class="text-secondary">الفصل: {{ $content->chapter->title ?? '-' }}</small><br>
                    <span
                        class="badge badge-status {{ $content->status }}">{{ $content->status == 'approved' ? 'معتمد' : ($content->status == 'rejected' ? 'مرفوض' : 'معلق') }}</span>
                </div>
            </div>

            {{-- أدوات التحكم --}}
            <div class="d-flex align-items-center flex-wrap justify-content-end mt-2">

                {{-- عرض المحتوى --}}
                <button class="btn btn-sm btn-outline-info me-2" data-bs-toggle="modal"
                    data-bs-target="#viewContentModal{{ $content->id }}">
                    <i class="fa-solid fa-eye"></i> عرض
                </button>

                {{-- ملخص --}}
                <button class="btn btn-sm btn-outline-warning me-2" data-bs-toggle="modal"
                    data-bs-target="#summaryContentModal{{ $content->id }}">
                    <i class="fa-solid fa-file-pen"></i> ملخص
                </button>

                {{-- تغيير الحالة + النقاط --}}
                <form action="{{ route('supervisor.contents.updateStatus', $content->id) }}" method="POST"
                    class="d-flex align-items-center">
                    @csrf
                    @method('PUT')
                    <select name="status" class="form-select form-select-sm me-2 status-select"
                        onchange="togglePointsInput(this, {{ $content->id }})" required>
                        <option value="">اختر الحالة</option>
                        <option value="approved" {{ $content->status == 'approved' ? 'selected' : '' }}>اعتماد</option>
                        <option value="rejected" {{ $content->status == 'rejected' ? 'selected' : '' }}>رفض</option>
                        <option value="pending" {{ $content->status == 'pending' ? 'selected' : '' }}>معلق</option>
                    </select>

                    <input type="number" name="points" id="pointsInput{{ $content->id }}"
                        class="form-control form-control-sm points-input me-2" placeholder="نقاط" min="1"
                        max="100" style="display: none;" />

                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- 🔹 مودال عرض المحتوى --}}
        <x-modal id="viewContentModal{{ $content->id }}" title="تفاصيل المحتوى" maxWidth="lg">
            <div class="content-details">
                {{-- العنوان والوصف --}}
                <h4 class="fw-bold text-primary mb-2">{{ $content->title }}</h4>
                <p class="text-muted mb-4">{{ $content->description ?? '— لا يوجد وصف —' }}</p>

                {{-- حالة المحتوى --}}
                <div class="mb-3">
                    <span class="badge badge-status {{ $content->status }}">
                        {{ $content->status == 'approved' ? '✅ معتمد' : ($content->status == 'rejected' ? '❌ مرفوض' : '⏳ معلق') }}
                    </span>
                </div>

                {{-- الفصل المرتبط --}}
                @if ($content->chapter)
                    <div class="chapter-info mb-4 d-flex align-items-center gap-3 border p-2 rounded bg-light">
                        <img src="{{ asset('storage/' . $content->chapter->file) }}"
                            alt="{{ $content->chapter->title }}" class="rounded"
                            style="width: 70px; height: 70px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">{{ $content->chapter->title }}</h6>
                            <small class="text-secondary d-block">{{ $content->chapter->description }}</small>
                        </div>
                    </div>
                @endif

                {{-- عرض الفيديو إن وُجد --}}
                @if ($content->video)
                    <div class="video-container mb-3">
                        <video class="w-100 rounded shadow-sm" controls preload="metadata"
                            poster="{{ asset('assets/img/video-placeholder.jpg') }}">
                            <source src="{{ asset('storage/' . $content->video) }}" type="video/mp4">
                            متصفحك لا يدعم تشغيل الفيديو.
                        </video>
                    </div>
                @endif

                {{-- عرض الملف إن وُجد --}}
                @if ($content->file)
                    <a href="{{ asset('storage/' . $content->file) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fa-solid fa-file-arrow-down me-1"></i> تحميل الملف
                    </a>
                @endif

                {{-- معلومات إضافية --}}
                <div class="mt-4 small text-secondary">
                    <p class="mb-1"><strong>نوع المحتوى:</strong> {{ $content->type ?? '-' }}</p>
                    <p class="mb-1"><strong>تاريخ الإنشاء:</strong> {{ $content->created_at->format('Y-m-d H:i') }}
                    </p>
                    <p><strong>آخر تحديث:</strong> {{ $content->updated_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </x-modal>


        {{-- مودال إرسال ملخص --}}
        <x-modal id="summaryContentModal{{ $content->id }}" title="إرسال ملخص للمحتوى" maxWidth="md">
            <form action="{{ route('supervisor.content-summaries.store') }}" method="POST">
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
                    <textarea name="notes" id="notes{{ $content->id }}" rows="3" class="form-control" required></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-paper-plane"></i> إرسال
                    </button>
                </div>
            </form>
        </x-modal>
    @empty
        <p class="text-muted text-center">لا يوجد محتوى لعرضه</p>
    @endforelse

    {{-- 🔹 تفعيل وإخفاء إدخال النقاط عند اختيار "اعتماد" --}}
    <script>
        function togglePointsInput(select, id) {
            const pointsInput = document.getElementById(`pointsInput${id}`);
            if (select.value === 'approved') {
                pointsInput.style.display = 'block';
                pointsInput.setAttribute('required', 'true');
            } else {
                pointsInput.style.display = 'none';
                pointsInput.removeAttribute('required');
                pointsInput.value = '';
            }
        }
    </script>

</x-dash-layout>
