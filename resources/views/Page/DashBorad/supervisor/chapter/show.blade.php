<x-dash-layout>
    <div class="container py-4">

        <div class="mb-4">
            <h2 class="fw-bold">تفاصيل الفصل: {{ $chapter->title }}</h2>
            <a href="{{ route('supervisor.courses.show', $chapter->course_id) }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> العودة إلى المقرر
            </a>
        </div>

        {{-- Chapter Info --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                معلومات الفصل
            </div>
            <div class="card-body">
                <p><strong>عنوان الفصل:</strong> {{ $chapter->title }}</p>
                <p><strong>الوصف:</strong> {{ $chapter->description ?? '-' }}</p>
                <p><strong>الملفات:</strong>
                    @if ($chapter->file)
                        <i class="fas fa-file-import    "></i>
                        <a href="{{ asset('storage/' . $chapter->file) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            تحميل
                        </a>
                    @else
                        لا يوجد
                    @endif
                </p>
            </div>
        </div>

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
