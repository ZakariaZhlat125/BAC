@props(['chapterId'])

<div class="card border-0 shadow-lg rounded-3 p-4 bg-white">
    <div class="card-body">

        <!-- بيانات الفيديو -->
        <div id="videoDetails" class="mb-4" style="display:none;">
            <div class="bg-gradient-primary text-white p-3 rounded mb-2">
                <h5 id="videoTitle" class="mb-0 fw-bold"></h5>
            </div>
            <p class="mb-1">
                <i class="fa-solid fa-info-circle me-1 text-primary"></i>
                <strong>الوصف:</strong>
                <span id="videoDescription"></span>
            </p>
            <p class="mb-0">
                <i class="fa-solid fa-list-ul me-1 text-primary"></i>
                <strong>نوع:</strong>
                <span id="videoType"></span>
            </p>
        </div>

        <!-- بيانات الطالب -->
        <div id="studentDetails" class="mb-4" style="display:none;">
            <div class="bg-gradient-info text-white p-3 rounded mb-2">
                <h6 class="mb-0 fw-bold">بيانات الطالب</h6>
            </div>
            <p class="mb-1"><i class="fa-solid fa-user-graduate me-1 text-info"></i><strong>الاسم:</strong> <span
                    id="studentName"></span></p>
            <p class="mb-1"><i class="fa-solid fa-layer-group me-1 text-info"></i><strong>التخصص:</strong> <span
                    id="studentMajor"></span></p>
            <p class="mb-1"><i class="fa-solid fa-calendar me-1 text-info"></i><strong>السنة الدراسية:</strong> <span
                    id="studentYear"></span></p>
            <p class="mb-1"><i class="fa-solid fa-star me-1 text-warning"></i><strong>النقاط:</strong> <span
                    id="studentPoints"></span></p>
            <p class="mb-0"><i class="fa-solid fa-quote-left me-1 text-info"></i><strong>نبذة:</strong> <span
                    id="studentBio"></span></p>
        </div>

        <!-- مشغل الفيديو -->
        <div class="ratio ratio-16x9 mb-3">
            <video id="videoPlayer" class="w-100 rounded" controls>
                <source id="videoSource" src="" type="video/mp4">
                متصفحك لا يدعم تشغيل الفيديو.
            </video>
        </div>

        <!-- اختيار شرح آخر -->
        <div class="mb-3">
            <label class="form-label fw-bold">اختر شرحاً آخر:</label>
            <select id="videoSelector" class="form-select">
                <option disabled selected>-- اختر الفيديو --</option>
            </select>
        </div>

        <!-- احصائيات -->
        <div class="mb-3" id="videoStats" style="display:none;">
            <div class="mb-2">
                <span id="averageRating" class="text-primary fw-bold">متوسط التقييم: 0</span>
            </div>
        </div>

        <!-- تقييم -->
        <div class="mb-3">
            <label class="form-label fw-bold">تقييم المقطع:</label>
            <div id="ratingStars" class="d-flex gap-2">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa-regular fa-star fa-2x text-warning star" data-value="{{ $i }}"></i>
                @endfor
            </div>
        </div>

        <!-- التعليقات -->
        <div class="mb-3">
            <label class="form-label fw-bold">التعليقات:</label>
            <textarea id="commentBody" class="form-control" rows="3" placeholder="أضف تعليقك هنا..."></textarea>
            <button id="submitComment" class="btn btn-primary mt-2">إرسال التعليق</button>
        </div>

        <!-- قائمة التعليقات -->
        <div id="commentsList" class="mt-3"></div>
    </div>
</div>

<style>
    /* تدرجات لونية للبطاقات */
    .bg-gradient-primary {
        background: linear-gradient(45deg, #007bff, #6610f2);
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #00c2ff, #00e5ff);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chapterId = "{{ $chapterId }}";
        const selector = document.getElementById('videoSelector');
        const videoSource = document.getElementById('videoSource');
        const videoPlayer = document.getElementById('videoPlayer');

        // تفاصيل الفيديو
        const videoDetails = document.getElementById('videoDetails');
        const videoTitle = document.getElementById('videoTitle');
        const videoDescription = document.getElementById('videoDescription');
        const videoType = document.getElementById('videoType');

        // تفاصيل الطالب
        const studentDetails = document.getElementById('studentDetails');
        const studentName = document.getElementById('studentName');
        const studentMajor = document.getElementById('studentMajor');
        const studentYear = document.getElementById('studentYear');
        const studentPoints = document.getElementById('studentPoints');
        const studentBio = document.getElementById('studentBio');

        const videoStats = document.getElementById('videoStats');
        const averageRating = document.getElementById('averageRating');
        const commentBody = document.getElementById('commentBody');
        const submitComment = document.getElementById('submitComment');
        const commentsList = document.getElementById('commentsList');

        let selectedContentId = null;
        let videosData = [];
        let rating = 0;

        // تحميل الفيديوهات
        fetch(`/home/videoContent/${chapterId}`)
            .then(res => res.json())
            .then(data => {
                videosData = data;
                if (data.length === 0) {
                    selector.innerHTML = '<option disabled selected>لا يوجد محتويات فيديو</option>';
                    return;
                }
                data.forEach(content => {
                    const option = document.createElement('option');
                    option.value = content.video;
                    option.textContent = content.title;
                    option.dataset.student = content.student?.user?.name ?? 'طالب مجهول';
                    option.dataset.contentId = content.id;
                    selector.appendChild(option);
                });
                // اختيار أول فيديو تلقائياً
                selector.selectedIndex = 1;
                selector.dispatchEvent(new Event('change'));
            });

        // تغيير الفيديو
        selector.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (!selected.value) return;

            // تحديث مشغل الفيديو
            videoSource.src = `/storage/${selected.value}`;
            videoPlayer.load();

            selectedContentId = selected.dataset.contentId;
            videoStats.style.display = "block";

            // العثور على الفيديو المختار لتفاصيله
            const currentVideo = videosData.find(item => item.id == selectedContentId);
            if (currentVideo) {
                // عرض تفاصيل الفيديو
                videoTitle.textContent = currentVideo.title;
                videoDescription.textContent = currentVideo.description ?? 'لا يوجد وصف';
                videoType.textContent = currentVideo.type ?? 'غير محدد';
                videoDetails.style.display = 'block';

                // عرض بيانات الطالب
                const student = currentVideo.student;
                const user = student?.user;
                studentName.textContent = user?.name ?? 'طالب مجهول';
                studentMajor.textContent = student?.major ?? 'غير محدد';
                studentYear.textContent = student?.year ?? '-';
                studentPoints.textContent = student?.points ?? '0';
                studentBio.textContent = student?.bio ?? 'لا توجد نبذة';
                studentDetails.style.display = 'block';
            }

            loadComments(selectedContentId);
            loadEvaluations(selectedContentId);
        });

        // تحميل التعليقات
        function loadComments(contentId) {
            fetch(`/comments?content_id=${contentId}`)
                .then(res => res.json())
                .then(data => {
                    commentsList.innerHTML = '';
                    data.forEach(c => {
                        const div = document.createElement('div');
                        div.classList.add('mb-2', 'p-2', 'border', 'rounded');
                        div.innerHTML = `<strong>${c.user.name}</strong>: ${c.body}`;
                        commentsList.appendChild(div);
                    });
                });
        }

        // تحميل التقييمات والمتوسط
        function loadEvaluations(contentId) {
            fetch(`/evaluations/${contentId}`)
                .then(res => res.json())
                .then(data => {
                    averageRating.textContent = `متوسط التقييم: ${data.average_rating}`;

                    document.querySelectorAll('.star').forEach(s => s.classList.remove('fa-solid'));
                    if (data.user_rating) {
                        for (let i = 0; i < data.user_rating; i++) {
                            document.querySelectorAll('.star')[i].classList.add('fa-solid');
                        }
                    }
                });
        }

        // إرسال التعليق
        submitComment.addEventListener('click', function() {
            if (!commentBody.value || !selectedContentId) return;
            fetch('/comments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    content_id: selectedContentId,
                    body: commentBody.value
                })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    commentBody.value = '';
                    loadComments(selectedContentId);
                }
            });
        });

        // تقييم النجوم
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                rating = this.dataset.value;
                document.querySelectorAll('.star').forEach(s => s.classList.remove('fa-solid'));
                for (let i = 0; i < rating; i++) {
                    document.querySelectorAll('.star')[i].classList.add('fa-solid');
                }
                if (selectedContentId) {
                    fetch('/evaluations', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            content_id: selectedContentId,
                            rating: rating
                        })
                    }).then(() => loadEvaluations(selectedContentId));
                }
            });
        });
    });
</script>
