<x-dash-layout>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fa;
            direction: rtl;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .stats-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
        }

        .stat-card {
            background: linear-gradient(135deg, #0a4b5f, #0e6b8a);
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 25px 20px;
            flex: 1 1 23%;
            min-width: 220px;
            text-align: center;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .stat-card h6 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-card p {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .card-section {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
            padding: 25px;
            margin-bottom: 25px;
        }

        .card-section h5 {
            color: #0a4b5f;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .students-cards {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }

        .student {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
            padding: 15px;
            width: 30%;
        }

        .student img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-bottom: 8px;
        }

        .student h6 {
            font-weight: 600;
            color: #0a4b5f;
            margin: 0;
        }
    </style>

    <div class="container py-4">
        <h4 class="fw-bold text-secondary dashboard-header">لوحة الإشراف</h4>

        <!-- إحصائيات عامة -->
        <div class="stats-cards">
            <div class="stat-card">
                <i class="bi bi-people"></i>
                <h6>الطلاب تحت الإشراف</h6>
                <p>{{ $studentsCount }}</p>
            </div>
            <div class="stat-card">
                <i class="bi bi-journal-text"></i>
                <h6>محتويات بانتظار المراجعة</h6>
                <p>{{ $pendingContents }}</p>
            </div>
            <div class="stat-card">
                <i class="bi bi-calendar-week"></i>
                <h6>الفعاليات خلال الأسبوع</h6>
                <p>{{ array_sum(json_decode($eventsPerDay, true)) }}</p>
            </div>
            <div class="stat-card">
                <i class="bi bi-clock-history"></i>
                <h6>الساعات التطوعية</h6>
                <p>{{ $totalVolunteerHours }}</p>
            </div>
        </div>

        <!-- الرسوم البيانية -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card-section">
                    <h5>عدد الفعاليات خلال أيام الأسبوع</h5>
                    <canvas id="eventsChart"></canvas>
                </div>
            </div>

            {{-- <div class="col-md-6">
                <div class="card-section">
                    <h5>عدد المحتويات حسب التخصص</h5>
                    <canvas id="specializationChart"></canvas>
                </div>
            </div> --}}
            <div class="col-md-6">
                <div class="card-section mt-4">
                    <h5>نمو الإحصائيات الشهرية</h5>
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

        </div>

        <!-- جدول التخصصات -->
        <div class="card-section">
            <h5>إحصائية المحتويات في كل تخصص</h5>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>التخصص</th>
                        <th>عدد المحتويات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($specializationStats as $stat)
                        <tr>
                            <td>{{ $stat->specialization_name }}</td>
                            <td>{{ $stat->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">لا توجد بيانات بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    @if ($topStudent && $topStudent->count() > 0)
        @php
            // icons for ranking
            $icons = [
                0 => 'assets/img/first.png',
                1 => 'assets/img/secound.png',
                2 => 'assets/img/thered.png',
            ];

            // ترتيب العرض (الثاني، الأول، الثالث)
            $order = [1, 0, 2];
        @endphp

        @foreach ($order as $index)
            @if (isset($topStudent[$index]))
                @php $student = $topStudent[$index]; @endphp

                <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                    <div class="card leader-card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <div class="leader-icon mb-3">
                                <img src="{{ asset($icons[$index]) }}" alt="rank" class="img-fluid"
                                    style="max-height: 80px;">
                            </div>

                            {{-- Avatar --}}
                            @if ($student->user->gender === 'male')
                                <div class="avatar-wrapper mb-3">
                                    <img src="{{ asset('assets/img/ic_avatar_2.png') }}"
                                        class="avatar rounded-circle shadow-sm"
                                        alt="{{ $student->user->name ?? 'Student' }}"
                                        style="width: 90px; height: 90px; object-fit: cover;">
                                </div>
                            @else
                                <div class="avatar-wrapper mb-3">
                                    <img src="{{ asset('assets/img/ic_avatar.png') }}"
                                        class="avatar rounded-circle shadow-sm"
                                        alt="{{ $student->user->name ?? 'Student' }}"
                                        style="width: 90px; height: 90px; object-fit: cover;">
                                </div>
                            @endif


                            {{-- Name --}}
                            <h5 class="fw-bold text-dark mb-1">
                                {{ $student->user->name ?? 'مجهول' }}
                            </h5>

                            {{-- Points --}}
                            <p class="text-warning small mb-1">بمجموع نقاط تساوي</p>
                            <p class="points fw-semibold text-primary mb-0">
                                {{ (int) $student->points }} points
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="col-12 text-center">
            <div class="alert alert-warning mt-4" role="alert">
                ⚠️ لا يوجد بيانات لعرضها حالياً
            </div>
        </div>
    @endif
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const months = {!! $months !!};
        const growthData = {!! $growthData !!};

        new Chart(document.getElementById("growthChart"), {
            type: "line",
            data: {
                labels: months,
                datasets: [{
                    label: "نمو عدد المحتويات",
                    data: growthData,
                    borderColor: "#0a4b5f",
                    borderWidth: 3,
                    fill: false,
                    tension: 0.3
                }]
            },
        });
    </script>


    <script>
        // 🔹 بيانات الفعاليات في الأسبوع
        const days = {!! $days !!};
        const eventsData = {!! $eventsPerDay !!};

        new Chart(document.getElementById('eventsChart'), {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    label: 'عدد الفعاليات',
                    data: eventsData,
                    backgroundColor: '#0a4b5f'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 🔹 محتويات التخصصات
        const specializationNames = @json($specializationStats->pluck('specialization_name'));
        const specializationCounts = @json($specializationStats->pluck('total'));

        new Chart(document.getElementById('specializationChart'), {
            type: 'doughnut',
            data: {
                labels: specializationNames,
                datasets: [{
                    data: specializationCounts,
                    backgroundColor: ['#0a4b5f', '#0e6b8a', '#17a2b8', '#ffc107', '#dc3545']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</x-dash-layout>
