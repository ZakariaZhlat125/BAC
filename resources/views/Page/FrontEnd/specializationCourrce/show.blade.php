<x-app-layout>
    <div class="container my-4">

        <!-- بطاقة العنوان -->
        <div class="card border-0 shadow rounded-lg mb-4 bg-gradient-success text-white">
            <div class="card-body text-center">
                <h4 class="fw-bold m-0">{{ $chapter->title }}</h4>
            </div>
        </div>

        <!-- تفاصيل الفصل -->
        <div class="card border-0 shadow rounded-lg mb-5 d-flex flex-row align-items-center p-3">
            <div class="bg-light rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                <img src="/assets/img/ic_chapter.png" alt="" style="width:40px; height:20px;">
            </div>
            <div class="flex-grow-1">
                <h5 class="fw-bold text-primary mb-1">{{ $chapter->title }}</h5>
                <p class="text-muted mb-0">{{ $chapter->description }}</p>
            </div>
            <a href="{{ asset('storage/' . $chapter->file) }}" download class="btn btn-outline-primary ms-3">
                <i class="fa-solid fa-download me-2"></i> تحميل
            </a>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item me-2 mx-2 shadow-md">
                <button data-tab="video" class="tab-button btn btn-warning fw-bold px-4 d-flex align-items-center">
                    <i class="fa-solid fa-play-circle me-2"></i> شرح الشابتر
                </button>
            </li>
            <li class="nav-item mx-2 shadow-md">
                <button data-tab="summary" class="tab-button btn btn-light fw-bold px-4 d-flex align-items-center">
                    <i class="fa-solid fa-book-open me-2"></i> ملخصات
                </button>
            </li>
        </ul>

        <!-- Components -->
        <div id="video-component" data-state="active">
            <x-video-content :chapterId="$chapter->id" />
        </div>

        <div id="summary-component" class="d-none" data-state="inactive">
            <x-summary-content :chapterId="$chapter->id" />
        </div>

    </div>

    <style>
        .bg-gradient-success {
            background: linear-gradient(45deg, #28a745, #43cea2);
        }
    </style>

    <script>
        const tabs = document.querySelectorAll(".tab-button");
        const components = {
            video: document.getElementById("video-component"),
            summary: document.getElementById("summary-component"),
        };

        tabs.forEach(tab => {
            tab.addEventListener("click", () => {
                const selected = tab.dataset.tab;

                // Update components state
                Object.keys(components).forEach(key => {
                    if (key === selected) {
                        components[key].classList.remove("d-none");
                        components[key].dataset.state = "active";
                    } else {
                        components[key].classList.add("d-none");
                        components[key].dataset.state = "inactive";
                    }
                });

                // Update buttons style
                tabs.forEach(btn => {
                    if (btn.dataset.tab === selected) {
                        btn.classList.remove("btn-light");
                        btn.classList.add("btn-warning");
                    } else {
                        btn.classList.remove("btn-warning");
                        btn.classList.add("btn-light");
                    }
                });
            });
        });
    </script>
</x-app-layout>
