<x-app-layout>
    <div class="container my-4">

        <!-- 🧾 Course Info -->
        <div class="card shadow-sm border-0 mb-4 course-info-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold">{{ $course->title }}</h6>
                    <span class="text-muted">
                        السنة الدراسية:
                        <span class="text-success">{{ $course->year->name ?? '-' }}</span>
                    </span>
                </div>

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

                <p><strong>التخصص:</strong> <span class="text-success">{{ $course->specializ->title ?? '-' }}</span></p>
                <p><strong>الفصل:</strong> <span class="text-success">{{ $course->semester ?? '-' }}</span></p>
                <p class="text-muted">{{ $course->description }}</p>
            </div>
        </div>

        <!-- 📚 Course Content -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">محتوى المقرر</h6>
                <i class="fa-solid fa-bookmark text-gold"></i>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">عدد الفصول</span>
                    <span class="badge bg-secondary">{{ $course->chapters->count() }}</span>
                </div>

                <!-- ✅ Available Chapters -->
                <div class="section-title text-success mb-2">
                    <i class="fa-solid fa-circle-check"></i> الفصول المتوفرة
                </div>

                @forelse ($chaptersWithContent as $chapter)
                    <div class="chapter-item d-flex justify-content-between align-items-center border-bottom py-2">
                        <div class="d-flex align-items-center gap-3">
                            <img src="/assets/img/ic_chapter.png" alt="" style="width: 70px; height: 40px;">
                            <span class="fw-semibold">{{ $chapter->title }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Download -->
                            @if ($chapter->file)
                                <a href="{{ asset('storage/' . $chapter->file) }}" download
                                    class="text-decoration-none">
                                    <i class="fa-solid fa-download text-primary mx-2"></i>
                                </a>
                            @endif

                            <!-- View -->
                            <a href="{{ route('home.specialization.cources.chapters', $chapter->id) }}"
                                class="text-decoration-none mx-2">
                                <i class="fa-solid fa-eye text-success"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">لا توجد فصول حالياً.</p>
                @endforelse

                <!-- ❌ Unavailable Chapters -->
                <div class="section-title text-danger mt-4 mb-2">
                    <i class="fa-solid fa-circle-xmark"></i> فصول غير متوفرة
                </div>

                @forelse ($chaptersWithoutContent as $chapter)
                    <div class="chapter-item d-flex justify-content-between align-items-center border-bottom py-2">
                        <div class="d-flex align-items-center gap-3">
                            <img src="/assets/img/ic_chapter.png" alt="" style="width: 70px; height: 40px;">
                            <span class="fw-semibold">{{ $chapter->title }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Download -->
                            @if ($chapter->file)
                                <a href="{{ asset('storage/' . $chapter->file) }}" download
                                    class="text-decoration-none">
                                    <i class="fa-solid fa-download text-primary mx-2"></i>
                                </a>
                            @endif

                            <!-- View -->
                            <a href="{{ route('home.specialization.cources.chapters', $chapter->id) }}"
                                class="text-decoration-none mx-2">
                                <i class="fa-solid fa-eye text-success"></i>
                            </a>
                        </div>
                        {{-- <button class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-hourglass-half me-1"></i> جاري الإضافة لاحقاً
                        </button> --}}
                    </div>
                @empty
                    <p class="text-muted">جميع الفصول متوفرة 🎉</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
