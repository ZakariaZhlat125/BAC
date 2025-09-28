<x-dash-layout>
    <style>
        body {
            background: linear-gradient(to right, #f1f4f9, #d8dee8);
            font-family: 'Tajawal', sans-serif;
        }

        .stat-card {
            border-radius: 20px;
            padding: 30px 15px;
            color: #fff;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .icon-container {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .stat-card h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .stat-card p {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* تدرجات مختلفة لكل بطاقة */
        .bg-primary-gradient {
            background: linear-gradient(45deg, #007bff, #6610f2);
        }

        .bg-info-gradient {
            background: linear-gradient(45deg, #00c2ff, #00e5ff);
        }

        .bg-success-gradient {
            background: linear-gradient(45deg, #28a745, #43cea2);
        }

        .bg-warning-gradient {
            background: linear-gradient(45deg, #ffc107, #ffecb3);
        }

        .bg-danger-gradient {
            background: linear-gradient(45deg, #dc3545, #ff416c);
        }

        .bg-secondary-gradient {
            background: linear-gradient(45deg, #6c757d, #979797);
        }
    </style>

    <!-- Cards Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-4 my-4">
            <div class="stat-card bg-primary-gradient">
                <div class="icon-container">
                    <i class="bi bi-people fs-3"></i>
                </div>
                <h6>الطلاب تحت الإشراف</h6>
                <p>{{ $studentsCount }}</p>
            </div>
        </div>
        <div class="col-md-4 my-4">
            <div class="stat-card bg-info-gradient">
                <div class="icon-container">
                    <i class="bi bi-journal fs-3"></i>
                </div>
                <h6>محتويات بانتظار المراجعة</h6>
                <p>{{ $pendingContents }}</p>
            </div>
        </div>
        <div class="col-md-4 my-4">
            <div class="stat-card bg-success-gradient">
                <div class="icon-container">
                    <i class="bi bi-geo-alt fs-3"></i>
                </div>
                <h6>الفعاليات المعلقة</h6>
                <p>{{ $eventsPending }}</p>
            </div>
        </div>
        <div class="col-md-4 my-4">
            <div class="stat-card bg-danger-gradient">
                <div class="icon-container">
                    <i class="bi bi-arrow-up-square fs-3"></i>
                </div>
                <h6>طلبات الترقية</h6>
                <p>{{ $upgradeRequests }}</p>
            </div>
        </div>
        <div class="col-md-4 my-4">
            <div class="stat-card bg-secondary-gradient">
                <div class="icon-container">
                    <i class="bi bi-collection fs-3"></i>
                </div>
                <h6>إجمالي المحتويات</h6>
                <p>{{ $contentsCount }}</p>
            </div>
        </div>
        <div class="col-md-4 my-4">
            <div class="stat-card bg-warning-gradient">
                <div class="icon-container">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <h6>الساعات التطوعية (من النقاط)</h6>
                <p>{{ $totalVolunteerHours }}</p>
            </div>
        </div>
    </div>
</x-dash-layout>
