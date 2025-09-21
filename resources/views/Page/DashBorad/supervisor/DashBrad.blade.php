<x-dash-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Tajawal', sans-serif;
        }

        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .task-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .student-badge {
            text-align: center;
        }

        .student-badge img {
            width: 60px;
            height: 60px;
        }
    </style>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-people fs-3 text-primary"></i>
                <h6>الطلاب تحت الإشراف</h6>
                <p class="fw-bold">5</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-journal fs-3 text-info"></i>
                <h6>محتويات بانتظار المراجعة</h6>
                <p class="fw-bold">10</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-geo-alt fs-3 text-success"></i>
                <h6>الفعاليات التي تحتاج موافقة</h6>
                <p class="fw-bold">3</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-clock-history fs-3 text-warning"></i>
                <h6>الساعات التطوعية المعتمدة</h6>
                <p class="fw-bold">480</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h6>تطور مشاركة الطلاب مع مرور الوقت</h6>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h6>نسبة قبول مقابل رفض المحتوى</h6>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h6>عدد المحتويات المرفوضة يومياً خلال الأسبوع</h6>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Best Students + Tasks -->
    <div class="row g-3">
        <!-- Best Students -->
        <div class="col-md-8">
            <div class="stat-card">
                <h6>أفضل ثلاث طلاب مشاركين تحت إشرافك</h6>
                <div class="d-flex justify-content-around mt-3">
                    <div class="student-badge">
                        <img src="https://cdn-icons-png.flaticon.com/512/2583/2583344.png" alt="medal">
                        <p>عمر أحمد</p>
                    </div>
                    <div class="student-badge">
                        <img src="https://cdn-icons-png.flaticon.com/512/2583/2583341.png" alt="medal">
                        <p>نورة سعيد</p>
                    </div>
                    <div class="student-badge">
                        <img src="https://cdn-icons-png.flaticon.com/512/2583/2583347.png" alt="medal">
                        <p>علي ناصر</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task List -->
        <div class="col-md-4">
            <div class="task-card">
                <h6>قائمة المهام</h6>
                <ul class="list-unstyled mt-3">
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        10 طلبات مراجعة المحتوى
                        <button class="btn btn-outline-secondary btn-sm">معاينة</button>
                    </li>
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        2 طلب ترقية لطالب نشط
                        <button class="btn btn-outline-secondary btn-sm">معاينة</button>
                    </li>
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        5 طلبات إصدار شهادة
                        <button class="btn btn-outline-secondary btn-sm">معاينة</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Line Chart
        new Chart(document.getElementById("lineChart"), {
            type: 'line',
            data: {
                labels: ["يناير", "فبراير", "مارس", "ابريل", "مايو"],
                datasets: [{
                        label: "المجموعة 1",
                        data: [100, 200, 300, 400, 500],
                        borderColor: "blue",
                        fill: false
                    },
                    {
                        label: "المجموعة 2",
                        data: [50, 150, 250, 350, 450],
                        borderColor: "green",
                        fill: false
                    }
                ]
            }
        });

        // Pie Chart
        new Chart(document.getElementById("pieChart"), {
            type: 'pie',
            data: {
                labels: ["المقبولة", "المرفوضة"],
                datasets: [{
                    data: [80, 20],
                    backgroundColor: ["#4caf50", "#f44336"]
                }]
            }
        });

        // Bar Chart
        new Chart(document.getElementById("barChart"), {
            type: 'bar',
            data: {
                labels: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"],
                datasets: [{
                    label: "عدد المحتويات",
                    data: [5, 10, 8, 6, 12, 4, 9],
                    backgroundColor: "#2196f3"
                }]
            }
        });
    </script>

</x-dash-layout>
