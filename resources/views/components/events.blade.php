@props(['events'])

<h2 class="text-center mb-4" style="color: var(--kfu-green);">
    الفعاليات القادمة لجميع التخصصات
</h2>

@if ($events->count() > 0)
    <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            @foreach ($events as $index => $event)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="card card-event shadow-sm border-0 mx-auto" style="max-width: 360px;">

                        {{-- العنوان --}}
                        <div class="card-header text-center bg-transparent border-0">
                            <h5>{{ $event->event_name }}</h5>
                        </div>

                        <div class="card-body text-center">

                            {{-- الوقت --}}
                            @if ($event->event_date)
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <img src="{{ asset('assets/img/ic_time.png') }}" width="22" height="22"
                                        class="ms-2">
                                    <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }} -
                                        {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}

                                    </span>
                                </div>
                            @endif

                            {{-- المكان --}}
                            @if ($event->location)
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <img src="{{ asset('assets/img/ic_location.png') }}" width="22" height="22"
                                        class="ms-2">
                                    <span class="text-muted">{{ $event->location }}</span>
                                </div>
                            @endif

                            {{-- الوصف --}}
                            @if ($event->description)
                                <p class="small text-secondary mb-3">
                                    {{ $event->description }}
                                </p>
                            @endif

                            {{-- صورة --}}
                            @if ($event->attach)
                                <img src="{{ asset('storage/' . $event->attach) }}" class="img-fluid rounded mb-3"
                                    alt="event-image">
                            @endif

                            {{-- الأزرار --}}
                            <div class="text-center">
                                <button class="btn btn-kfu btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#eventModal{{ $event->id }}">
                                    المزيد
                                </button>

                                @role('student')
                                    @php
                                        $student = Auth::user()->student;
                                        $participated =
                                            $event->participations->where('student_id', $student->id)->count() > 0;
                                    @endphp
                                    @if (!$participated)
                                        <form action="{{ route('user.events.participate', $event->id) }}" method="POST"
                                            class="d-inline-block ms-2">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                الاشتراك
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-secondary ms-2">مشترك بالفعل</span>
                                    @endif
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal تفاصيل -->
                <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background: var(--kfu-green); color: white;">
                                <h5 class="modal-title">{{ $event->event_name }}</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @if ($event->event_date)
                                    <p><strong>الوقت:</strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y - h:i A') }}
                                    </p>
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
                                {{-- @if ($event->attach)
                                    <a href="{{ asset('storage/' . $event->attach) }}" target="_blank"
                                        class="btn btn-kfu">
                                        تحميل المرفق
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- أزرار التنقل --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
@else
    <p class="text-center text-muted">لا توجد فعاليات قادمة.</p>
@endif
