<x-dash-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">تفاصيل الفصل: {{ $chapter->title }}</h2>
            <a href="{{ route('supervisor.courses.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> العودة إلى المقرر
            </a>
        </div>

        @php
            $student = Auth::user()->student;
        @endphp

        @if ($student && $student->is_upgraded)
            {{-- زر فتح المودال لإضافة محتوى جديد --}}
            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contentModal">
                    <i class="fa-solid fa-plus-circle me-1"></i> إضافة محتوى جديد
                </button>
            </div>
        @endif

        {{-- Chapter Info --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                معلومات الفصل
            </div>
            <div class="card-body">
                <p><strong>عنوان الفصل:</strong> {{ $chapter->title }}</p>
                <p><strong>الوصف:</strong> {{ $chapter->description ?? '-' }}</p>
            </div>
        </div>

        {{-- محتويات الفصل --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white fw-bold">
                محتويات الفصل
            </div>
            <div class="card-body">
                @if ($chapter->contents->count() > 0)
                    <ul class="list-group">
                        @foreach ($chapter->contents as $content)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $content->title }}</h6>
                                    <p class="text-muted mb-0">{{ $content->description ?? '-' }}</p>

                                    {{-- زر تحميل الملف إن وجد --}}
                                    @if ($content->file)
                                        <a href="{{ asset('storage/' . $content->file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary mt-2 me-1">
                                            <i class="fa-solid fa-file-arrow-down me-1"></i> تحميل الملف
                                        </a>
                                    @endif
                                </div>

                                <div class="btn-group">
                                    {{-- زر عرض المحتوى في مودال --}}
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#viewContentModal{{ $content->id }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    @if ($student && $student->is_upgraded)
                                        {{-- زر تعديل --}}
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editContentModal{{ $content->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- زر حذف --}}
                                        <form action="{{ route('user.contents.destroy', $content->id) }}" method="POST"
                                            class="d-inline-block"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المحتوى؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>

                            {{-- مودال عرض المحتوى --}}
                            <x-modal id="viewContentModal{{ $content->id }}" title="تفاصيل المحتوى" maxWidth="lg">
                                <h5>{{ $content->title }}</h5>
                                <p>{{ $content->description ?? '-' }}</p>
                                @if ($content->file)
                                    <a href="{{ asset('storage/' . $content->file) }}" target="_blank"
                                        class="btn btn-primary">
                                        <i class="fa-solid fa-file-arrow-down me-1"></i> تحميل الملف
                                    </a>
                                @endif
                            </x-modal>

                            {{-- مودال تعديل المحتوى --}}
                            <x-modal id="editContentModal{{ $content->id }}" title="تعديل المحتوى" maxWidth="lg">
                                <form method="POST" action="{{ route('user.contents.update', $content->id) }}"
                                    enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-6">
                                        <label class="form-label">عنوان المحتوى</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ old('title', $content->title) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">ملف (اختياري)</label>
                                        <input type="file" name="file" class="form-control">
                                        @if ($content->file)
                                            <small class="text-muted">الملف الحالي:
                                                {{ basename($content->file) }}</small>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="description" rows="3" class="form-control">{{ old('description', $content->description) }}</textarea>
                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> حفظ التغييرات
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">لا توجد محتويات لهذا الفصل بعد.</p>
                @endif
            </div>
        </div>



        {{-- مودال إنشاء محتوى جديد --}}
        <x-modal id="contentModal" title="إضافة محتوى جديد" maxWidth="lg">
            <x-content.create-content :chapter="$chapter"/>

        </x-modal>


        {{-- Related Course Info --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                معلومات المقرر المرتبط
            </div>
            <div class="card-body">
                <p><strong>عنوان المقرر:</strong> {{ $chapter->course->title ?? '-' }}</p>
                <p><strong>الوصف:</strong> {{ $chapter->course->description ?? '-' }}</p>
                <p><strong>الفصل الدراسي:</strong> {{ $chapter->course->semester ?? '-' }}</p>
                <p><strong>السنة:</strong> {{ optional($chapter->course->year)->name ?? '-' }}</p>
                <p><strong>التخصص:</strong> {{ optional($chapter->course->specializ)->title ?? '-' }}</p>
            </div>
        </div>

    </div>
</x-dash-layout>
