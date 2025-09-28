<x-dash-layout>
    <h2 class="fw-bold mb-4 text-center">المحتويات المعتمدة</h2>

    @forelse ($content as $item)
        <div class="card mb-3 p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-primary">{{ $item->title }}</h5>
                    <p class="text-muted mb-1">{{ $item->description ?? '-' }}</p>
                    <small class="text-secondary">
                        الفصل: {{ $item->chapter->title ?? '-' }}
                    </small>
                </div>

                <div class="d-flex gap-2">
                    {{-- زر عرض التفاصيل --}}
                    <button class="btn m-2 btn-sm btn-info" data-bs-toggle="modal"
                        data-bs-target="#viewContentModal{{ $item->id }}">
                        <i class="fa-solid fa-eye"></i>
                    </button>

                    {{-- زر تعديل --}}
                    <button class="btn btn-sm  m-2  btn-warning" data-bs-toggle="modal"
                        data-bs-target="#editContentModal{{ $item->id }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    {{-- زر حذف --}}
                    <form action="{{ route('user.contents.destroy', $item->id) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn  m-2  btn-sm btn-danger">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- مودال عرض التفاصيل --}}
        <x-modal id="viewContentModal{{ $item->id }}" title="تفاصيل المحتوى" maxWidth="lg">
            <h5 class="fw-bold">{{ $item->title }}</h5>
            <p>{{ $item->description ?? '-' }}</p>

            <p class="mb-1"><strong>الفصل:</strong> {{ $item->chapter->title ?? '-' }}</p>
            <p class="mb-1"><strong>الوصف:</strong> {{ $item->chapter->description ?? '-' }}</p>

            @if ($item->file)
                <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn-outline-primary mt-2">
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
        </x-modal>

        {{-- مودال تعديل المحتوى --}}
        <x-modal id="editContentModal{{ $item->id }}" title="تعديل المحتوى" maxWidth="lg">
            <form action="{{ route('user.contents.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" name="title" value="{{ $item->title }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" rows="3" class="form-control">{{ $item->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">الملف (اختياري)</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-check"></i> تحديث
                    </button>
                </div>
            </form>
        </x-modal>
    @empty
        <p class="text-muted text-center">لا يوجد محتوى لعرضه</p>
    @endforelse
</x-dash-layout>
