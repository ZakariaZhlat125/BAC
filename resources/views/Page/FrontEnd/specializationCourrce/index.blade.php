<x-app-layout>
    <style>

    </style>

    <div class="container my-4">

        <!-- Card: Course Info -->
        <div class="card shadow-sm border-0 mb-4 course-info-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold">{{ $course->title }}</h6>
                    <span class="text-muted">
                        السنة الدراسية:
                        <span class="text-success">{{ $course->year->name ?? '-' }}</span>
                    </span>
                </div>

                <!-- Progress Difficulty -->
                <div class="my-3">
                    <label class="fw-bold">صعوبة المقرر:</label>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar progress-bar-gradient" role="progressbar" style="width: 50%"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mt-1">
                        <span>سهل</span>
                        <span>صعب</span>
                    </div>
                </div>

                <p class="mb-1">
                    <span class="fw-bold">التخصص:</span>
                    <span class="text-success">{{ $course->specializ->title ?? '-' }}</span>
                </p>
                <p class="mb-1">
                    <span class="fw-bold">الفصل:</span>
                    <span class="text-success">{{ $course->semester ?? '-' }}</span>
                </p>
                <p class="text-muted">
                    {{ $course->description }}
                </p>
            </div>
        </div>

        <!-- Card: Course Content -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">محتوى المقرر</h6>
                <i class="fa-solid fa-bookmark text-gold"></i>
            </div>
            <div class="card-body">

                <!-- Progress -->
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">عدد الفصول</span>
                    <span class="badge bg-secondary">{{ count($course->chapters) }}</span>
                </div>

                <!-- Available Chapters -->
                <div class="section-title text-success">
                    <i class="fa-solid fa-circle-check"></i> الفصول المتوفرة
                </div>

                @forelse ($course->chapters as $chapter)
                    <div class="chapter-item d-flex justify-content-between align-items-center">
                        <img src="/assets/img/ic_chapter.png" alt="" style="width: 100px; height: 40px;">
                        <span>{{ $chapter->title }}</span>
                        <div class="d-flex gap-2">
                            <!-- Download -->
                            <a href="{{ asset('storage/' . $chapter->file) }}" download class="text-decoration-none">
                                <i class="fa-solid fa-download text-primary mx-2"></i>
                            </a>

                            <!-- Show -->
                            <a href="{{ route('home.specialization.cources.chapters', $chapter->id) }}"
                                class="text-decoration-none mx-2">
                                <i class="fa-solid fa-eye text-success"></i>
                            </a>
                        </div>

                    </div>
                @empty
                    <p class="text-muted">لا يوجد فصول متوفرة حالياً.</p>
                @endforelse

                <!-- Unavailable Chapters -->
                <div class="section-title text-danger mt-4">
                    <i class="fa-solid fa-circle-xmark"></i> فصول غير متوفرة
                </div>

                <div class="chapter-item d-flex justify-content-between align-items-center">
                    <span>سيتم إضافة محتوى لاحقاً</span>
                    <button class="btn btn-request btn-sm">
                        <i class="fa-solid fa-plus"></i> طلب محتوى
                    </button>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
