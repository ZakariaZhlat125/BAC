<x-app-layout>
    @include('components.top-section-front')
    <style>
        .leader-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 1rem;
        }

        .leader-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .avatar-wrapper {
            position: relative;
        }

        .avatar-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 18px;
            height: 18px;
            background: #ffc107;
            border: 2px solid #fff;
            border-radius: 50%;
        }

        .points {
            font-size: 1.1rem;
        }
    </style>
    <div style="background-color: var(--kfu-green); width: 100%;">
        <div class="py-6 row">
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

            <div class=" col-2" style="margin-top: 5rem;">
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
            <div class="col-2"><img class="img-card" style="margin-top: 150px;" src="assets/img/ic_top.png"></div>
            <div class="col-8">
                <h1 style="color: var(--kfu-green); font-size: 50px;  margin-top: 150px; text-align: center;"> أعلى ثلاث
                    طلاب في التخصص </h1>
                <p style="color: black; text-align: center; font-size: 35px; text-align: center; margin-top: 75px;">
                    نفتخر بالإعلان عن نجوم التميز في تخصصنا، واللي أثبتوا بجدارتهم إن الطموح والعمل الجاد يصنعون
                    الفارق.<br> هؤلاء هم أصحاب أعلى النقاط في التخصص : </p>
            </div>
            <div class="col-2"><img class="img-card" style="margin-top: 150px;" src="assets/img/ic_medel.png"></div>


        </div>

    </div>


    <div class="container py-5">
        <div class="row justify-content-center align-items-end g-4">

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

        </div>
    </div>



    <x-events :events="$events" />
    <br>
    <br>

    <x-coursecs.specialization-cources :specialization="$specialization" :years="$years" />

    <br>

    <x-open-data :countEvents="$countEvents" :countStudents="$countStudents" />


</x-app-layout>
