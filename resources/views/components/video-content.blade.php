@props(['chapterId'])

<div class="card border-0 shadow-lg rounded-3 p-3 bg-light">
    <div class="card-body">
        <!-- مشغل الفيديو -->
        <div class="ratio ratio-16x9 mb-3">
            <video id="videoPlayer" class="w-100 rounded" controls>
                <source id="videoSource" src="" type="video/mp4">
                متصفحك لا يدعم تشغيل الفيديو.
            </video>
        </div>

        <!-- بيانات الطالب -->
        <p id="studentName" class="fw-bold text-center text-warning">
            اختر مقطعاً لعرض بيانات الطالب
        </p>

        <!-- اختيار شرح آخر -->
        <div class="mb-3">
            <label class="form-label">اختر شرحاً آخر:</label>
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
            <label class="form-label">تقييم المقطع:</label>
            <div id="ratingStars" class="d-flex gap-1">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa-regular fa-star fa-2x text-warning star" data-value="{{ $i }}"></i>
                @endfor
            </div>
        </div>

        <!-- التعليقات -->
        <div class="mb-3">
            <label class="form-label">التعليقات:</label>
            <textarea id="commentBody" class="form-control" rows="3" placeholder="أضف تعليقك هنا..."></textarea>
            <button id="submitComment" class="btn btn-primary mt-2">إرسال التعليق</button>
        </div>

        <!-- قائمة التعليقات -->
        <div id="commentsList" class="mt-3"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chapterId = "{{ $chapterId }}";
        const selector = document.getElementById('videoSelector');
        const videoSource = document.getElementById('videoSource');
        const videoPlayer = document.getElementById('videoPlayer');
        const studentName = document.getElementById('studentName');
        const videoStats = document.getElementById('videoStats');
        const averageRating = document.getElementById('averageRating');
        const commentBody = document.getElementById('commentBody');
        const submitComment = document.getElementById('submitComment');
        const commentsList = document.getElementById('commentsList');
        let selectedContentId = null;
        let rating = 0;

        // تحميل الفيديوهات
        fetch(`/home/videoContent/${chapterId}`)
            .then(res => res.json())
            .then(data => {
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

                // اختيار أول فيديو تلقائي
                selector.selectedIndex = 1;
                selector.dispatchEvent(new Event('change'));
            });

        // تغيير الفيديو
        selector.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (!selected.value) return;

            videoSource.src = `/storage/${selected.value}`;
            videoPlayer.load();
            studentName.textContent = "الطالب: " + selected.dataset.student;
            selectedContentId = selected.dataset.contentId;
            videoStats.style.display = "block";

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
                })
                .then(res => res.json())
                .then(data => {
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

                // إرسال التقييم
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
