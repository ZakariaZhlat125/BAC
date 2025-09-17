<x-app-layout>
    <div class="container mt-4">
        <div class="col-md-4 col-4">
        </div>
        <p class="text-center mb-4"
            style="font-size: 32px; margin: 10%; background-color: #09595F; color: white; padding: 20px; border-radius: 10px;">
            مرحبًا بك في منصة مجتمع إدارة الأعمال – فضاءك الأكاديمي والاجتماعي!</p>
        <div class="row">
            <div class="col-md-5 col-4">
                <img src="static/img/bac.png" class="w-100">
            </div>

            <div class="col-md-5 col-4">
                <img style="margin: 20%;" src="assets/img/kfu_logo.png" class="w-100">
            </div>
            <div class="col-md-4 col-4">
            </div>


        </div>
    </div>

    <div style="background-color: var(--kfu-green); width: 100%;">
        <div class="row">
            <div class="col-3">
                <img class="img-card" style="transform: rotate(45deg); padding: 16px;"
                    src="{{ asset($specialization->image1) }}">
            </div>

            <div class="col-5">
                <h1 style="font-size: 70px; color: white; margin-top: 150px;">
                    {{ $specialization->title }}
                </h1>
            </div>

            <div class="col-2">
                <img class="img-card-small" src="{{ asset($specialization->image2) }}">
            </div>

            <div class="col-2">
                <img class="img-card" src="{{ asset($specialization->image3) }}">
            </div>
        </div>

        <div class="container">
            <p style="color: white; text-align: center; font-size: 35px;">
                {{ $specialization->description }}
            </p>
        </div>
        <br>
    </div>



    <div style=" width: 100%;">
        <div class="row">
            <div class="col-2"><img class="img-card" style="margin-top: 150px;" src="static/img/ic_top.png"></div>
            <div class="col-8">
                <h1 style="color: var(--kfu-green); font-size: 50px;  margin-top: 150px; text-align: center;"> أعلى ثلاث
                    طلاب في التخصص </h1>
                <p style="color: black; text-align: center; font-size: 35px; text-align: center; margin-top: 75px;">
                    نفتخر بالإعلان عن نجوم التميز في تخصصنا، واللي أثبتوا بجدارتهم إن الطموح والعمل الجاد يصنعون
                    الفارق.<br> هؤلاء هم أصحاب أعلى النقاط في التخصص : </p>
            </div>
            <div class="col-2"><img class="img-card" style="margin-top: 150px;" src="static/img/ic_medel.png"></div>


        </div>

    </div>


    {{-- <div class="container py-5">
    <div class="row justify-content-center align-items-end">

        <?php if ($top_students && count($top_students) > 0): ?>
        <?php
        // order: 2nd, 1st, 3rd
        $icons = ['static/img/secound.png', 'static/img/first.png', 'static/img/thered.png'];
        $positions = [1 => '🥈', 0 => '🥇', 2 => '🥉']; // order for layout
        $order = [1, 0, 2]; // second, first, third
        ?>

        <?php foreach ($order as $index): ?>
        <?php if (isset($top_students[$index])):
                    $student = $top_students[$index]; ?>
        <div class="col-12 col-md-3 mt-<?php echo $index == 0 ? '2' : ($index == 1 ? '5' : '4'); ?>">
            <div class="leader-card">
                <div class="leader-icon silver">
                    <img class="leader-icon silver" src="<?php echo $icons[$index]; ?>">
                </div>
                <br><br><br>
                <img src="static/img/ic_avatar.png" class="avatar" alt="<?php echo htmlspecialchars($student['Name']); ?>">
                <h5 class="mt-2"><?php echo htmlspecialchars($student['Name']); ?></h5>
                <p class="text-warning">بمجموع نقاط تساوي</p>
                <p class="points"><?php echo (int) $student['Points']; ?> points</p>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>

        <?php else: ?>
        <div class="col-12 text-center">
            <p class="text-danger">⚠️ لا يوجد بيانات لعرضها حالياً</p>
        </div>
        <?php endif; ?>

    </div>
</div>

<h2 class="section-title">الفعاليات القادمة لجميع التخصصات</h2>


<section class="card-carousel slider-containe">
    <div class="carousel-track ">

        <?php
        foreach ($events as $event) {


            ?>
        <div class="camp-card">
            <h2 class="lec-card-title"><?php echo $event['EventName']; ?></h2>
            <div class="detail-label">الوقت: <img src="static/img/ic_time.png" style="width: 24px; height: 24px;">
            </div>
            <div class="detail-value">موعد إقامة الورشة الإعدادية التعريفية</div>
            <div class="detail-value"><?php echo $event['EventDate']; ?></div>

            <div class="detail-label">المكان:<img src="static/img/ic_location.png" style="width: 24px; height: 24px;">
            </div>
            <div class="detail-value"><?php echo $event['Location']; ?></div>


            <div class="invitation">
                <p>نسعد بحضوركم</p>
            </div>
            <!--                static/img/test_img.png-->
            <img src="<?php echo $event['attach']; ?>" style="width: 250px; height: auto; margin-top: 10px; border-radius: 16px;">
            <div style="text-align: center; margin-top: 10px;">
                <p class="btn-kfu" style="width: fit-content; margin: auto;">المزيد</p>
            </div>
        </div>
        <?php } ?>


    </div>
</section> --}}
    <br>
    <br>

    <div style="width: 95%; margin: 0 2.5%">
        <h2 class="section-title">مواد تخصص {{ $specialization->title }}</h2>
        <p class="text-muted">{{ $specialization->description }}</p>

        @foreach ($years as $year)
            @php
                $chunks = $year->courses->chunk(6); // 6 كورسات في السلايد
            @endphp

            @if ($chunks->isEmpty())
                {{-- <p class="text-muted">لا يوجد مقررات لهذه السنة</p> --}}
                <div></div>
            @else
                <h2 class="section-sub-title">{{ $year->name }}</h2>
                <div id="carousel-year-{{ $year->id }}" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($chunks as $index => $chunk)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="row g-2">
                                    @foreach ($chunk as $course)
                                        <div class="col-2">
                                            <div class="card h-100 text-center p-2">
                                                <div class="camp-card">
                                                    {{-- <a href="{{ route('course.show', $course->id) }}"> --}}
                                                    <img src="{{ asset('assets/img/ic_management.png') }}"
                                                        style="width: 70px; height: auto; margin-top: 10px; border-radius: 16px;">
                                                    <div style="text-align: center; margin-top: 10px;">
                                                        <h2 class="lec-card-title"
                                                            style="width: fit-content; margin: auto;">
                                                            {{ $course->title }}
                                                        </h2>
                                                    </div>
                                                    {{-- </a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Dots -->
                    <div class="d-flex justify-content-center mt-3">
                        @foreach ($chunks as $i => $_)
                            <button type="button" data-bs-target="#carousel-year-{{ $year->id }}"
                                data-bs-slide-to="{{ $i }}"
                                class="custom-dot {{ $i === 0 ? 'active' : '' }}"
                                {{ $i === 0 ? 'aria-current=true' : '' }} aria-label="الشريحة {{ $i + 1 }}">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>


    <br>
    <br>
    <br>


    <h2 class="section-sub-title">البيانات المفتوحة</h2>

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
    </div>
</x-app-layout>
