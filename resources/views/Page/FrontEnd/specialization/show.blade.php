<x-app-layout>
    @include('components.top-section-front')

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
        <div class="row justify-content-center align-items-end">

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
                        <div class="col-12 col-md-3 mt-{{ $index == 0 ? '2' : ($index == 1 ? '5' : '4') }}">
                            <div class="leader-card text-center p-3 shadow rounded bg-white">
                                <div class="leader-icon mb-3">
                                    <img class="img-fluid" src="{{ asset($icons[$index]) }}" alt="rank">
                                </div>

                                <img src="{{ asset('static/img/ic_avatar.png') }}" class="avatar rounded-circle mb-2"
                                    alt="{{ $student->user->name ?? 'Student' }}">

                                <h5 class="mt-2 fw-bold">
                                    {{ $student->user->name ?? 'مجهول' }}
                                </h5>

                                <p class="text-warning small mb-1">بمجموع نقاط تساوي</p>
                                <p class="points fw-bold text-primary">
                                    {{ (int) $student->points }} points
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-danger">⚠️ لا يوجد بيانات لعرضها حالياً</p>
                </div>
            @endif

        </div>
    </div>


    <x-events :events="$events" />
    <br>
    <br>

    <x-coursecs.specialization-cources  :specialization="$specialization" :years="$years"/>

    <br>

    <x-open-data :countEvents="$countEvents" :countStudents="$countStudents" />


</x-app-layout>
