@props(['chapterId'])

<div class="card border-0 shadow-lg rounded-3 p-3 bg-light">
    <div class="card-body">

        <!-- بيانات الطالب -->
        <p id="studentName" class="fw-bold text-center text-warning">
            اختر مقطعاً لعرض بيانات الطالب
        </p>

        <!-- اختيار ملخص آخر -->
        <div class="mb-3">
            <label class="form-label">اختر ملخصاً آخر:</label>
            <select id="summarySelector" class="form-select">
                <option disabled selected>-- اختر الملخص --</option>
            </select>
        </div>

        <!-- احصائيات -->
        <div class="mb-3" id="summaryStats" style="display:none;">
            <span id="averageRating" class="text-primary fw-bold">متوسط التقييم: 0</span>
        </div>

        <!-- تقييم -->
        <div class="mb-3">
            <label class="form-label">تقييم الملخص:</label>
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
        const selector = document.getElementById('summarySelector');
        const studentName = document.getElementById('studentName');
        const summaryStats = document.getElementById('summaryStats');
        const averageRating = document.getElementById('averageRating');
        const commentBody = document.getElementById('commentBody');
        const submitComment = document.getElementById('submitComment');
        const commentsList = document.getElementById('commentsList');
        let selectedContentId = null;
        let rating = 0;

        // تحميل الملخصات
        fetch(`/home/summaryContent/${chapterId}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    selector.innerHTML = '<option disabled selected>لا يوجد ملخصات</option>';
                    return;
                }
                data.forEach(content => {
                    const option = document.createElement('option');
                    option.value = content.id;
                    option.textContent = content.title;
                    option.dataset.student = content.student?.user?.name ?? 'طالب مجهول';
                    selector.appendChild(option);
                });
                selector.selectedIndex = 1;
                selector.dispatchEvent(new Event('change'));
            });

        // تغيير الملخص المحدد
        selector.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (!selected.value) return;

            studentName.textContent = "الطالب: " + selected.dataset.student;
            selectedContentId = selected.value;
            summaryStats.style.display = "block";

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
