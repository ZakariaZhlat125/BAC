<x-dash-layout>
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Tajawal', sans-serif;
        }

        .content-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 20px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
        }

        .status-badge {
            font-size: 0.85rem;
            border-radius: 8px;
            padding: 6px 10px;
            font-weight: 600;
        }

        .status-approved {
            background-color: #198754;
            color: #fff;
        }

        .status-pending {
            background-color: #ffc107;
            color: #000;
        }

        .status-rejected {
            background-color: #dc3545;
            color: #fff;
        }

        .content-actions button {
            transition: 0.2s;
        }

        .content-actions button:hover {
            transform: scale(1.05);
        }
    </style>

    <h2 class="fw-bold mb-4 text-center text-primary">
        <i class="fa-solid fa-layer-group me-2"></i> المحتويات
    </h2>

    @forelse ($content as $item)
        <div class="content-card mb-3">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div>
                    <h5 class="text-dark fw-bold mb-1">{{ $item->title }}</h5>
                    <p class="text-muted mb-1">{{ $item->description ?? '-' }}</p>
                    <small class="text-secondary d-block mb-1">
                        الفصل: {{ $item->chapter->title ?? '-' }}
                    </small>

                    {{-- 🔹 عرض الحالة --}}
                    <span
                        class="status-badge 
                        {{ $item->status == 'approved' ? 'status-approved' : ($item->status == 'rejected' ? 'status-rejected' : 'status-pending') }}">
                        {{ $item->status == 'approved' ? 'معتمد ✅' : ($item->status == 'rejected' ? 'مرفوض ❌' : 'معلق ⏳') }}
                    </span>
                </div>

                {{-- الأزرار --}}
                <div class="content-actions d-flex align-items-center mt-2">
                    {{-- عرض --}}
                    <button class="btn btn-sm btn-outline-info me-2" data-bs-toggle="modal"
                        data-bs-target="#viewContentModal{{ $item->id }}" title="عرض">
                        <i class="fa-solid fa-eye"></i>
                    </button>

                    {{-- تعديل --}}
                    <button class="btn btn-sm btn-outline-warning me-2" data-bs-toggle="modal"
                        data-bs-target="#editContentModal{{ $item->id }}" title="تعديل">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    {{-- حذف --}}
                    <form action="{{ route('user.contents.destroy', $item->id) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- مودال عرض التفاصيل --}}
        <x-modal id="viewContentModal{{ $item->id }}" title="تفاصيل المحتوى" maxWidth="lg">
            <div class="p-2">
                <h5 class="fw-bold text-primary">{{ $item->title }}</h5>
                <p class="mb-1">{{ $item->description ?? '-' }}</p>

                <p class="mb-1"><strong>الفصل:</strong> {{ $item->chapter->title ?? '-' }}</p>
                <p class="mb-1"><strong>الوصف:</strong> {{ $item->chapter->description ?? '-' }}</p>

                {{-- 🔹 حالة المحتوى --}}
                <p class="mt-2">
                    <strong>الحالة:</strong>
                    <span
                        class="status-badge 
                        {{ $item->status == 'approved' ? 'status-approved' : ($item->status == 'rejected' ? 'status-rejected' : 'status-pending') }}">
                        {{ $item->status == 'approved' ? 'معتمد ✅' : ($item->status == 'rejected' ? 'مرفوض ❌' : 'معلق ⏳') }}
                    </span>
                </p>

                @if ($item->file)
                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-primary mt-2">
                        <i class="fa-solid fa-file-arrow-down me-1"></i> تحميل الملف
                    </a>
                @endif

                <hr>

                {{-- الملخص --}}
                @if ($item->summary)
                    <h6 class="text-success"><i class="fa-solid fa-file-pen me-1"></i> المراجعة</h6>
                    <p><strong>النوع:</strong> {{ $item->summary->type }}</p>
                    <p><strong>الملاحظات:</strong> {{ $item->summary->notes }}</p>
                @else
                    <p class="text-muted">لا يوجد ملخص بعد.</p>
                @endif
            </div>
        </x-modal>

        {{-- مودال تعديل المحتوى --}}
        <x-modal id="editContentModal{{ $item->id }}" title="تعديل المحتوى" maxWidth="lg">
            <form action="{{ route('user.contents.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">العنوان</label>
                    <input type="text" name="title" value="{{ $item->title }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">الوصف</label>
                    <textarea name="description" rows="3" class="form-control">{{ $item->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">الملف (اختياري)</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-check me-1"></i> تحديث
                    </button>
                </div>
            </form>
        </x-modal>
    @empty
        <p class="text-muted text-center mt-5">لا يوجد محتوى لعرضه</p>
    @endforelse
</x-dash-layout>
