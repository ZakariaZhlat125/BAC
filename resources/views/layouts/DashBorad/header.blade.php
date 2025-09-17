<div class="header d-flex align-items-center justify-content-between">
    <!-- بيانات المستخدم -->
    <div class="user-info d-flex align-items-center">
        <img id="user-avatar" src="{{ asset('assets/img/ic_avatar.png') }}" alt="صورة المستخدم" class="me-2">
        <div class="user-text text-end">
            <strong id="user-name">...</strong><br>
            <small id="user-email">...</small>
        </div>
    </div>
    @role('student')
        <!-- زر طلب الترقية -->
        <div class="user-info" id="upgradeBtnContainer">
            <button class="btn btn-kfu" data-bs-toggle="modal" data-bs-target="#upgradeModal">
                <img src="{{ asset('assets/img/ic_upgrade.png') }}" class="btn_icon"> طلب ترقية
            </button>
        </div>
    @endrole
    <!-- مكان عرض الحالة إذا كان موجود -->
    <div id="upgradeStatusContainer" class="mt-3"></div>
    <!-- أيقونات التنبيهات -->
    <div class="icons position-relative">
        <img src="{{ asset('assets/img/ic_notifications.png') }}" class="ic_notifications" data-bs-toggle="modal"
            data-bs-target="#notificationsModal" onclick="markNotificationsAsRead()">

        @if (auth()->user()->unreadNotifications->count() > 0)
            <span id="notificationsCount"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </div>



</div>

<x-notifications-modal />

<x-points-conversion-modal :points="370" supervisorName="د. أحمد الشريف" />


<!-- طلب ترقية الحساب -->
<x-modal id="upgradeModal" title="طلب ترقية الحساب" maxWidth="lg">
    <form id="upgradeForm" action="{{ route('user.upgrade-profile') }}" method="POST" enctype="multipart/form-data"
        style="display:inline;">
        @csrf

        <div class="mb-3 card p-2" style="font-size: 15px; background-color: #F3F3F3;">
            أقر أنني أرغب في ترقية حسابي إلى طالب متفاعل، وألتزم بالضوابط الأكاديمية والمعايير الأخلاقية.
        </div>

        <div class="mb-3 form-check custom-checkbox">
            <input type="checkbox" class="form-check-input" id="agreeTerms" name="agree_terms" required>
            <label class="form-check-label" for="agreeTerms" style="margin-right: 30px; color: black;">
                أوافق على الشروط والأحكام
            </label>
        </div>

        <div class="mb-3">
            <textarea class="form-control" name="reason" rows="2"
                placeholder="اشرح بإيجاز لماذا ترغب أن تكون طالبا متفاعلا (اختياري)" required></textarea>
        </div>

        <div class="mb-3">
            <label for="fileUpload" class="form-label">أرفق محتوى تجريبي (فيديو أو ملخص)</label>
            <input class="form-control" type="file" id="fileUpload" name="attach_file" required>
        </div>

        <ul class="custom-note-list fs-6">
            <li>الالتزام بالضوابط والمعايير</li>
            <li>رفع محتوى أصلي و مفيد</li>
            <li>الاستمرار في التفاعل (حد أدنى من المشاركات أو التفاعل)</li>
        </ul>
        <x-slot:footer>
            <button class="btn btn-kfu" type="submit" form="upgradeForm">إرسال الطلب للمراجعة</button>
        </x-slot:footer>
    </form>
</x-modal>
<script>
    function markNotificationsAsRead() {
        fetch("{{ route('notifications.read') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        }).then(response => {
            if (response.ok) {
                document.getElementById('notificationsCount')?.remove();
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        fetch('{{ url('/getMyData') }}', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ auth()->user()->api_token ?? '' }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);

                // تحديث الاسم والايميل
                document.getElementById('user-name').textContent = data.name ?? 'مستخدم';
                document.getElementById('user-email').textContent = data.email ?? '';

                // اختيار الصورة حسب الجنس
                let avatar = document.getElementById('user-avatar');
                if (data.gender && data.gender.toLowerCase() === 'male') {
                    avatar.src = "{{ asset('assets/img/ic_avatar_2.png') }}";
                } else {
                    avatar.src = "{{ asset('assets/img/ic_avatar.png') }}";
                }
            })
            .catch(error => {
                console.error("خطأ في جلب بيانات المستخدم:", error);
            });

        fetch('{{ url('/dashborad/upgrade-requests/my-status') }}', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ auth()->user()->api_token ?? '' }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const upgradeBtnContainer = document.getElementById('upgradeBtnContainer');
                const container = document.getElementById('upgradeStatusContainer');
                console.log('data', data);
                if (data.is_upgraded) {
                    // الطالب مترقّي بالفعل
                    if (upgradeBtnContainer) upgradeBtnContainer.style.display = 'none';
                    container.innerHTML = `
            <p class="text-success fw-bold">🎉 لقد تمت ترقيتك بنجاح.</p>
        `;
                } else if (data.has_request) {
                    // إخفاء زر طلب الترقية
                    if (upgradeBtnContainer) upgradeBtnContainer.style.display = 'none';

                    // عرض حالة الطلب
                    let badgeClass = 'badge bg-warning';
                    if (data.status === 'approved') badgeClass = 'badge bg-success';
                    else if (data.status === 'rejected') badgeClass = 'badge bg-danger';

                    container.innerHTML = `
            <p>لديك طلب ترقية حالي:</p>
            <span class="${badgeClass} p-2">${data.status.toUpperCase()}</span>
            <p><strong>السبب:</strong> ${data.reason ?? '-'}</p>
        `;
                } else {
                    // لا يوجد طلب ولا ترقية → إبقاء زر الترقية ظاهر
                    if (upgradeBtnContainer) upgradeBtnContainer.style.display = 'block';
                    container.innerHTML = '';
                }
            });

    });
</script>
