@props(['chapterId'])

<div class="card border-0 shadow-lg rounded-3 p-4 bg-white">
    <div class="card-body">

        <!-- عنوان الملخص وبيانات الطالب -->
        <div id="summaryDetails" class="mb-4" style="display:none;">
            <div class="bg-gradient-primary text-white p-3 rounded mb-3">
                <h5 id="summaryTitle" class="mb-0 fw-bold"></h5>
            </div>
            <p class="mb-2">
                <i class="fa-solid fa-file-lines me-1 text-primary"></i>
                <strong>الوصف:</strong>
                <span id="summaryDescription"></span>
            </p>
            <p class="mb-3">
                <i class="fa-solid fa-file-pdf me-1 text-danger"></i>
                <a id="summaryFileLink" href="#" target="_blank" class="text-decoration-underline">تحميل الملف</a>
            </p>
        </div>

        <div id="summarystudentDetails" class="mb-4" style="display:none;">
            <div class="bg-gradient-info text-white p-3 rounded mb-3">
                <h6 class="mb-0 fw-bold">بيانات الطالب</h6>
            </div>
            <p class="mb-1"><i class="fa-solid fa-user-graduate me-1 text-info"></i><strong>الاسم:</strong> <span
                    id="summarystudentName"></span></p>
            <p class="mb-1"><i class="fa-solid fa-layer-group me-1 text-info"></i><strong>التخصص:</strong> <span
                    id="summarystudentMajor"></span></p>
            <p class="mb-1"><i class="fa-solid fa-calendar me-1 text-info"></i><strong>السنة الدراسية:</strong> <span
                    id="summarystudentYear"></span></p>
            <p class="mb-1"><i class="fa-solid fa-star me-1 text-warning"></i><strong>النقاط:</strong> <span
                    id="summarystudentPoints"></span></p>
            <p class="mb-0"><i class="fa-solid fa-quote-left me-1 text-info"></i><strong>نبذة:</strong> <span
                    id="summarystudentBio"></span></p>
        </div>

        <!-- اختيار ملخص آخر -->
        <div class="mb-3">
            <label class="form-label fw-bold">اختر ملخصاً آخر:</label>
            <select id="summarySelector" class="form-select">
                <option disabled selected>-- اختر الملخص --</option>
            </select>
        </div>

        <!-- احصائيات -->
        <div class="mb-3" id="summaryStats" style="display:none;">
            <span id="summaryaverageRating" class="text-primary fw-bold">متوسط التقييم: 0</span>
        </div>

        <!-- تقييم -->
        <div class="mb-3">
            <label class="form-label fw-bold">تقييم الملخص:</label>
            <div id="summary_ratingStars" class="d-flex gap-2">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa-regular fa-star fa-2x text-warning star" data-value="{{ $i }}"></i>
                @endfor
            </div>
        </div>

        <!-- التعليقات -->
        <div class="mb-3">
            <label class="form-label fw-bold">التعليقات:</label>
            <textarea id="summary_commentBody" class="form-control" rows="3" placeholder="أضف تعليقك هنا..."></textarea>
            <button id="summary_submitComment" class="btn btn-primary mt-2">إرسال التعليق</button>
        </div>

        <!-- قائمة التعليقات -->
        <div id="summary_commentsList" class="mt-3"></div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chapterId = "{{ $chapterId }}";
        const selector = document.getElementById('summarySelector');
        const summaryTitle = document.getElementById('summaryTitle');
        const summaryDescription = document.getElementById('summaryDescription');
        const summaryFileLink = document.getElementById('summaryFileLink');
        const studentName = document.getElementById('summarystudentName');
        const studentMajor = document.getElementById('summarystudentMajor');
        const studentYear = document.getElementById('summarystudentYear');
        const studentPoints = document.getElementById('summarystudentPoints');
        const studentBio = document.getElementById('summarystudentBio');
        const summaryDetails = document.getElementById('summaryDetails');
        const studentDetails = document.getElementById('summarystudentDetails');
        const summaryStats = document.getElementById('summaryStats');
        const averageRating = document.getElementById('summaryaverageRating');
        const commentBody = document.getElementById('summary_commentBody');
        const submitComment = document.getElementById('summary_submitComment');
        const commentsList = document.getElementById('summary_commentsList');

        let selectedContentId = null;
        let summariesData = []; // لتخزين الملخصات
        let rating = 0;

        // تحميل الملخصات
        fetch(`/home/showSummaryContent/${chapterId}`)
            .then(res => res.json())
            .then(data => {
                summariesData = data;
                if (data.length === 0) {
                    selector.innerHTML = '<option disabled selected>لا يوجد ملخصات</option>';
                    return;
                }
                data.forEach(content => {
                    const option = document.createElement('option');
                    option.value = content.id;
                    option.textContent = content.title;
                    selector.appendChild(option);
                });
                // اختر أول ملخص تلقائياً
                selector.selectedIndex = 1;
                selector.dispatchEvent(new Event('change'));
            });

        // تغيير الملخص المحدد
        selector.addEventListener('change', function() {
            const selectedId = this.value;
            if (!selectedId) return;
            selectedContentId = selectedId;

            // العثور على الملخص الحالي
            const summary = summariesData.find(item => item.id == selectedId);
            if (summary) {
                // عرض تفاصيل الملخص
                summaryTitle.textContent = summary.title;
                summaryDescription.textContent = summary.description ?? 'لا يوجد وصف';
                summaryFileLink.href = `/storage/${summary.file}`;
                summaryDetails.style.display = 'block';

                // عرض بيانات الطالب
                const student = summary.student;
                const user = student?.user;
                studentName.textContent = user?.name ?? 'طالب مجهول';
                studentMajor.textContent = student?.major ?? 'غير محدد';
                studentYear.textContent = student?.year ?? '-';
                studentPoints.textContent = student?.points ?? '0';
                studentBio.textContent = student?.bio ?? 'لا توجد نبذة';
                studentDetails.style.display = 'block';
            }

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
            console.log("commentBody.value sum ", commentBody.value);
            console.log("selectedContentId sum ", selectedContentId);

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
