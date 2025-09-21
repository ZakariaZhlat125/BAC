<x-dash-layout>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Tajawal', sans-serif;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .progress-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 8px solid #e9ecef;
            border-top: 8px solid #ffc107;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 10px;
            font-weight: bold;
            color: #6c757d;
        }
    </style>
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">المعلومات الإضافية</h5>
            <button class="btn btn-outline-secondary btn-sm">تعديل</button>
        </div>

        <!-- Info Row -->
        <div class="row text-muted mb-3">
            <div class="col-md-3"><strong>المستوى الدراسي:</strong> {{ $user->student->yearRelation->name ?? '-' }}</div>
            <div class="col-md-3"><strong>التخصص:</strong> {{ $user->student->specializ->title ?? '-' }}</div>
            {{-- <div class="col-md-3"><strong>اسم المشرف:</strong> {{ $user->student->supervisor_name ?? '-' }}</div>
            <div class="col-md-3"><strong>ايميل المشرف:</strong> {{ $user->student->supervisor_email ?? '-' }}</div> --}}
        </div>

        <!-- About Me -->
        <div class="mb-4">
            <h6 class="fw-bold">نبذة عني</h6>
            <p class="text-secondary">
                {{ $user->student->bio ?? 'لا يوجد نبذة حالياً' }}
            </p>
        </div>

        <!-- Stats Section -->
        <div class="row g-3 text-center">
            <!-- ساعات التطوع -->
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-clock-history fs-3 text-primary"></i>
                    <h6 class="mt-2">عدد الساعات التطوعية المعتمدة</h6>
                    <p class="fw-bold mb-2">{{ $volunteerHours }} ساعات</p>
                    <a href="{{ route('user.certifications.show') }}" class="btn btn-outline-success btn-sm">طلب استبدال
                        نقاط</a>
                </div>
            </div>

            <!-- المحتويات المقبولة -->
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-journal-check fs-3 text-success"></i>
                    <h6 class="mt-2">المحتويات المقبولة</h6>
                    <p class="fw-bold mb-0">{{ $contentsCount }}</p>
                </div>
            </div>

            <!-- النقاط المكتسبة -->
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="progress-circle">{{ $points * 10 }}%</div>
                    <h6 class="mt-2">عدد النقاط المكتسبة</h6>
                    <p class="fw-bold mb-0">{{ $points }}</p>
                </div>
            </div>
        </div>
    </div>

</x-dash-layout>
