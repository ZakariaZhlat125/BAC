<x-dash-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">تفاصيل المقرر: {{ $course->title }}</h2>
            <a href="{{ route('user.getMyCources') }}" class="btn btn-secondary">
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

                                        <a href="{{ route('user.getMyChapter', $chapter->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>


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
