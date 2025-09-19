<x-app-layout>
    <div class="container my-4">

        <!-- عنوان الفصل -->
        <div class="card shadow-md border-0 mb-4">
            <div class="card-body text-center">
                <h4 class="fw-bold text-success">
                    <p>{{ $chapter->title }}</p>
                </h4>
            </div>
        </div>

        <div class="chapter-item d-flex justify-content-between align-items-center bg-light">
            <img src="/assets/img/ic_chapter.png" alt="" style="width: 100px; height: 40px;">
            <div class="d-flex flex-column p-3 ">
                <span class="fw-bold text-primary mb-2">{{ $chapter->title }}</span>
                <span class="text-muted">{{ $chapter->description }}</span>
            </div>
            <div class="d-flex gap-2">
                <!-- Download -->
                <a href="{{ asset('storage/' . $chapter->file) }}" download class="text-decoration-none">
                    <i class="fa-solid fa-download text-primary mx-2"></i>
                </a>
            </div>
        </div>
        <!-- تبويبات -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item me-2 mx-2 shadow-md">
                <button id="video-btn" class="btn btn-warning fw-bold px-4">شرح الشابتر</button>
            </li>
            <li class="nav-item mx-2 shadow-md">
                <button id="summary-btn" class="btn btn-light fw-bold px-4">ملخصات</button>
            </li>
        </ul>

        <!-- Components -->
        <div id="video-component">
            <x-video-content :chapterId="$chapter->id"/>
        </div>

        <div id="summary-component" class="d-none">
            <x-summary-content :chapterId="$chapter->id" />
        </div>

    </div>

    <!-- JavaScript -->
    <script>
        const videoBtn = document.getElementById('video-btn');
        const summaryBtn = document.getElementById('summary-btn');
        const videoComponent = document.getElementById('video-component');
        const summaryComponent = document.getElementById('summary-component');

        videoBtn.addEventListener('click', () => {
            videoComponent.classList.remove('d-none');
            summaryComponent.classList.add('d-none');

            videoBtn.classList.add('btn-warning');
            videoBtn.classList.remove('btn-light');

            summaryBtn.classList.remove('btn-warning');
            summaryBtn.classList.add('btn-light');
        });

        summaryBtn.addEventListener('click', () => {
            summaryComponent.classList.remove('d-none');
            videoComponent.classList.add('d-none');

            summaryBtn.classList.add('btn-warning');
            summaryBtn.classList.remove('btn-light');

            videoBtn.classList.remove('btn-warning');
            videoBtn.classList.add('btn-light');
        });
    </script>
</x-app-layout>
