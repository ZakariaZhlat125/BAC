<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div class="col-md-4 col-4">
        </div>
        <p class="text-center mb-4"
            style="font-size: 32px; margin: 10%; background-color: #09595F; color: white; padding: 20px; border-radius: 10px;">
            مرحبًا بك في منصة مجتمع إدارة الأعمال – فضاءك الأكاديمي والاجتماعي!</p>
        <div class="row">
            <div class="col-md-5 col-4">
                <img src="assets/img/bac.png" class="w-100">
            </div>

            <div class="col-md-5 col-4">
                <img style="margin: 20%;" src="assets/img/kfu_logo.png" class="w-100">
            </div>
            <div class="col-md-4 col-4">
            </div>

        </div>
    </div>

    <div class="container mt-4">
        <p class="text-center mb-4"
            style="font-size: 32px; margin-inline: 10%;  color: black; padding: 20px; border-radius: 10px;">


            هنا تبدأ رحلتك نحو التميّز<br> تشرح، تتعلّم، تحضر فعاليات، وتكسب نقاط تطوعية وشهادات تطوعية معتمدة.
            شارك زملاءك المعرفة، أنشئ محتوى تعليمي، نظّم ورش عمل وسيمينارات، وكن جزءًا من بيئة تفاعلية تدعم تطورك
            الأكاديمي .<br>
            كل تفاعل له قيمة، وكل إنجاز يصنع لك أثرًا في سجلّك الجامعي.<br>
            ابدأ رحلتك التعليمية الآن 🚀</p>
    </div>
    <section class="features py-5">
        <div class="container">
            <div class="row g-4">

                <div class="col-md-4">
                    <div class="feature-card card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <img src="assets/img/ic_activtes.png" style="width: 100px; height: 100px;"
                                    class="fas fa-book-open"></i>
                            </div>
                            <h3 class="card-title h4">الفعاليات المعتمدة</h3>
                            <p class="card-text">شارك في ورش عمل، ندوات، وفعاليات خاصة بأعمال الكلية، واكتسب شهادات
                                تطوعية معتمدة من الكلية.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <img src="assets/img/ic_edu.png" style="width: 100px; height: 100px;"
                                    class="fas fa-book-open"></i>
                            </div>
                            <h3 class="card-title h4">المحتوى التعليمي</h3>
                            <p class="card-text">اطّلع على شروحات ومحاضرات ومختلف أنواع المحتوى التدريبي المتعدد لتعزيز
                                فهمك للمقررات الأكاديمية.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card card">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <img src="assets/img/ic_points.png" style="width: 100px; height: 100px;"
                                    class="fas fa-book-open"></i>
                            </div>
                            <h3 class="card-title h4">النقاط والشهادات</h3>
                            <p class="card-text">اجمع نقاطًا من خلال تفاعلاتك ومشاركاتك، واحصل على شهادات معتمدة تُثري
                                سيرتك الذاتية والسجل الأكاديمي.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <h2 class="section-title">الفعاليات القادمة لجميع التخصصات</h2>

    @if ($events->count() > 0)
        <section class="card-carousel slider-containe">
            <div class="carousel-track">
                @foreach ($events as $event)
                    <div class="camp-card relative">

                        @if ($event->event_date)
                            <div class="detail-label">الوقت:
                                <img src="{{ asset('assets/img/ic_time.png') }}" style="width: 24px; height: 24px;">
                            </div>
                            <div class="detail-value">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d H:i') }}</div>
                        @endif

                        @if ($event->location)
                            <div class="detail-label">المكان:
                                <img src="{{ asset('assets/img/ic_location.png') }}" style="width: 24px; height: 24px;">
                            </div>
                            <div class="detail-value">{{ $event->location }}</div>
                        @endif

                        @if ($event->description)
                            <div class="invitation">
                                <p>{{ $event->description }}</p>
                            </div>
                        @endif

                        @if ($event->attach)
                            <img src="{{ asset('storage/' . $event->attach) }}"
                                style="width: 250px; height: auto; margin-top: 10px; border-radius: 16px;">
                        @endif

                        <div style="text-align: center; margin-top: 10px;">
                            <!-- زر عرض التفاصيل -->
                            <button class="btn btn-kfu" data-bs-toggle="modal"
                                data-bs-target="#eventshowModal{{ $event->id }}"
                                style="width: fit-content; margin: auto;">
                                المزيد
                            </button>

                            <!-- زر الاشتراك -->
                            @php
                                $student = Auth::user()->student;
                                $participated = $event->participations->where('student_id', $student->id)->count() > 0;
                            @endphp
                            @if (!$participated)
                                <form action="{{ route('user.events.participate', $event->id) }}" method="POST"
                                    class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        الاشتراك في الفعالية
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary mt-2">مشترك بالفعل</span>
                            @endif
                        </div>
                    </div>

                    <!-- Modal -->
                    <x-modal id="eventshowModal{{ $event->id }}" title="{{ $event->event_name }}" maxWidth="lg">
                        <h5>{{ $event->event_name }}</h5>
                        @if ($event->event_date)
                            <p><strong>الوقت:</strong>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d H:i') }}</p>
                        @endif
                        @if ($event->location)
                            <p><strong>المكان:</strong> {{ $event->location }}</p>
                        @endif
                        @if ($event->description)
                            <p>{{ $event->description }}</p>
                        @endif
                        @if ($event->supervisor)
                            <p><strong>المشرف:</strong> {{ $event->supervisor->user->name ?? '-' }}</p>
                        @endif
                        @if ($event->student)
                            <p><strong>الطالب:</strong> {{ $event->student->user->name ?? '-' }}</p>
                        @endif
                        @if ($event->attach)
                            <a href="{{ asset('storage/' . $event->attach) }}" target="_blank" class="btn btn-primary">
                                تحميل المرفق
                            </a>
                        @endif
                    </x-modal>
                @endforeach
            </div>
        </section>
    @else
        <p class="text-center text-muted">لا توجد فعاليات قادمة.</p>
    @endif



    <br>
    <br>
    <br>
    <h2 class="section-title">البيانات المفتوحة</h2>

    <div class="container my-4">
        <div class="card shadow-sm p-4 rounded-3" style="background-color: white; border-radius: 15px;">
            <div class="row text-center">

                <!-- الفعاليات -->

                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <img src="assets/img/ic_activities_2.png" style="width: 80px; height: 80px;">
                        <div class="text-center">
                            <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                                الفعاليات</h6>
                            <span class="text-warning fw-semibold"
                                style="color: var(--kuf-gold); font-size: 24px;">30</span>
                        </div>
                    </div>
                </div>

                <!-- المحتوى التعليمي -->
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <img src="assets/img/ic_media.png" style="width: 80px; height: 80px;">

                        <div class="text-center">
                            <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                                المحتوى
                                التعليمي</h6>
                            <span class="text-warning fw-semibold"
                                style="color: var(--kuf-gold); font-size: 24px;">300</span>
                        </div>
                    </div>
                </div>

                <!-- الطلاب النشطين -->
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <img src="assets/img/ic_active_std.png" style="width: 80px; height: 80px;">
                        <div class="text-center">

                            <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                                الطلاب
                                النشطين</h6>
                            <span class="text-warning fw-semibold"
                                style="color: var(--kuf-gold); font-size: 24px;">500</span>
                        </div>
                    </div>
                </div>


                <!-- الزوار -->
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <img src="assets/img/ic_visitors.png" style="width: 80px; height: 80px;">
                        <div class="text-center">

                            <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                                الزوار
                            </h6>
                            <span class="text-warning fw-semibold"
                                style="color: var(--kuf-gold); font-size: 24px;">1500</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>
