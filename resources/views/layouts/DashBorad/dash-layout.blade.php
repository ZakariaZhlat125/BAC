<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/cp_style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main_style.css') }}" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- الشريط الجانبي -->
    <div class="sidebar">
        <a href="{{ route('dashboard.show') }}">الرئيسية</a>
        {{-- <a href="{{ route('notification.show') }}">التنبيهات</a> --}}
        @role('admin')
            {{-- admin.students.index --}}
            <a href="{{ route('admin.students.index') }}">الطلاب</a>
            <a href="{{ route('admin.supervisors.index') }}">المشرفون</a>
        @endrole
        @role('student')
            <a href="{{ route('profile.show') }}">حسابي</a>
            <a href="{{ route('user.getMyCources') }}">كورساتي</a>
            <a href="{{ route('user.certifications.show') }}">اصدار شهادتي</a>
            <a href="{{ route('user.upgrade-requests.my') }}">طلب الترقية الخاص بي</a>
            <a href="{{ route('user.contents.index') }}"> عرض محتوياتي</a>
        @endrole

        @role('supervisor')
            <a href="{{ route('profile.show') }}">حسابي</a>
            <a href="{{ route('supervisor.content.show') }}">المحتوى</a>
            <a href="{{ route('supervisor.courses.index') }}">مقرراتي</a>
            <a href="{{ route('supervisor.events.index') }}">فعالياتي</a>
            <a href="{{ route('supervisor.upgrade-requests.index') }}">جميع طلبات الترقية</a>
            <a href="{{ route('supervisor.upgrade-requests.pending') }}">الطلبات المعلقة</a>
        @endrole
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
                تسجيل الخروج
            </button>
        </form>
    </div>


    <!-- المحتوى -->
    <div class="content">
        @include('layouts.DashBorad.header')
        <div class="card">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".sidebar a");
            const current = window.location.pathname;
            links.forEach(link => {
                if (link.getAttribute("href") === current) {
                    link.classList.add("active");
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
