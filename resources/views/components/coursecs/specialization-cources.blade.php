@props(['specialization', 'years'])
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
                                        <div class=" h-100 text-center p-2">
                                            <div class="camp-card">
                                                <a href="{{ route('home.specialization.cources', $course->id) }}">
                                                    <img src="{{ asset('assets/img/ic_management.png') }}"
                                                        style="display: block; margin: 10px auto; width: 70px; height: auto; border-radius: 16px;">
                                                    <div style="text-align: center; margin-top: 10px;">
                                                        <h2 class="lec-card-title"
                                                            style="width: fit-content; margin: auto;">
                                                            {{ $course->title }}
                                                        </h2>
                                                    </div>
                                                </a>
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
                            data-bs-slide-to="{{ $i }}" class="custom-dot {{ $i === 0 ? 'active' : '' }}"
                            {{ $i === 0 ? 'aria-current=true' : '' }} aria-label="الشريحة {{ $i + 1 }}">
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>
