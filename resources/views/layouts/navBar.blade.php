<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- الشعار -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fas fa-home me-2"></i> الرئيسية
        </a>

        <!-- زر إظهار القائمة للجوال -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- الروابط -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-end">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('specialization?specialization=إدارة%20الأعمال') }}">
                        إدارة الأعمال
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('specialization?specialization=سلسلة%20الأمدادات') }}">
                        سلسلة الأمدادات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('specialization?specialization=المحاسبة') }}">
                        المحاسبة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('specialization?specialization=المالية') }}">
                        المالية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('specialization?specialization=المخاطر%20والتأمين') }}">
                        المخاطر والتأمين
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('specialization?specialization=نظم%20المعلومات') }}">
                        نظم المعلومات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('specialization?specialization=اقتصاديات%20الاعمال') }}">
                        اقتصاديات الأعمال
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.show') }}">
                        لوحة التحكم
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
