<x-dash-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">تفاصيل المقرر: {{ $course->title }}</h2>
            <a href="{{ route('supervisor.courses.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> العودة للقائمة
            </a>
        </div>

        {{-- Course Info --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                معلومات المقرر
            </div>
            <div class="card-body">
                <p><strong>العنوان:</strong> {{ $course->title }}</p>
                <p><strong>الوصف:</strong> {{ $course->description ?? '-' }}</p>
                <p><strong>الفصل الدراسي:</strong> {{ $course->semester ?? '-' }}</p>
                <p><strong>السنة:</strong> {{ optional($course->year)->name ?? '-' }}</p>
                <p><strong>التخصص:</strong> {{ optional($course->specializ)->title ?? '-' }}</p>
            </div>
        </div>

        {{-- زر فتح المودال لإضافة فصل جديد --}}
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chapterModal">
                <i class="fa-solid fa-plus-circle me-1"></i> إضافة فصل جديد
            </button>
        </div>

        {{-- مودال إنشاء فصل جديد --}}
        <x-modal id="chapterModal" title="إضافة فصل جديد" maxWidth="lg">
            <form method="POST" action="{{ route('supervisor.chapters.store') }}" class="row g-3"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="col-md-6">
                    <label class="form-label">عنوان الفصل</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">مرفق</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-floppy-disk me-1"></i> حفظ
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- Chapters --}}
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                الفصول
            </div>
            <div class="card-body p-0">
                @if ($course->chapters->count() > 0)
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>عنوان الفصل</th>
                                <th>الوصف</th>
                                <th>الملفات</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->chapters as $chapter)
                                <tr>
                                    <td>{{ $chapter->id }}</td>
                                    <td>{{ $chapter->title }}</td>
                                    <td>{{ Str::limit($chapter->description, 50) }}</td>
                                    <td>
                                        {{-- زر التعديل --}}
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editChapterModal{{ $chapter->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- مودال التعديل --}}
                                        <x-modal id="editChapterModal{{ $chapter->id }}" title="تعديل الفصل"
                                            maxWidth="lg">
                                            <form method="POST"
                                                action="{{ route('supervisor.chapters.update', $chapter->id) }}"
                                                class="row g-3" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="col-md-6">
                                                    <label class="form-label">عنوان الفصل</label>
                                                    <input type="text" name="title" class="form-control"
                                                        value="{{ old('title', $chapter->title) }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">الوصف</label>
                                                    <textarea name="description" rows="3" class="form-control">{{ old('description', $chapter->description) }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">مرفق</label>
                                                    <input type="file" name="file" class="form-control">

                                                    @if (!empty($chapter?->file))
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $chapter->file) }}"
                                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                                عرض المرفق الحالي
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-12 text-end mt-3">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa-solid fa-floppy-disk me-1"></i> تحديث
                                                    </button>
                                                </div>
                                            </form>
                                        </x-modal>
                                        <a href="{{ route('supervisor.chapters.show', $chapter->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        {{-- زر الحذف --}}
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteChapterModal{{ $chapter->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                        {{-- مودال الحذف --}}
                                        <x-modal id="deleteChapterModal{{ $chapter->id }}" title="تأكيد الحذف"
                                            maxWidth="sm">
                                            <div class="text-center py-3">
                                                <p>هل أنت متأكد أنك تريد حذف الفصل
                                                    <strong>{{ $chapter->title }}</strong>؟
                                                </p>
                                                <form action="{{ route('supervisor.chapters.destroy', $chapter->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa-solid fa-trash me-1"></i> نعم، احذف
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">إلغاء</button>
                                            </div>
                                        </x-modal>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-muted py-3">لا توجد فصول حالياً</p>
                @endif
            </div>
        </div>
    </div>
</x-dash-layout>
