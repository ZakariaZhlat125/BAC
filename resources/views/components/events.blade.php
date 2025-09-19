@props(['events'])
<h2 class="section-title">الفعاليات القادمة لجميع التخصصات</h2>

@if ($events->count() > 0)

    <section class="card-carousel slider-containe">
        <div class="carousel-track">
            @foreach ($events as $event)
                <div class="camp-card relative">

                    @if ($event->event_date)
                        <div class="detail-label">الوقت:
                            <img src="{{ asset('assets/img/ic_time.png') }}"
                                style="margin: auto;width: 24px; height: 24px;">
                        </div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d H:i') }}</div>
                    @endif

                    @if ($event->location)
                        <div class="detail-label">
                            <P>المكان</P>
                            <img class="detail-value" src="{{ asset('assets/img/ic_location.png') }}"
                                style="margin: auto;width: 24px; height: 24px;">
                            <div class="detail-value">{{ $event->location }}</div>
                        </div>
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

                        @role('student')
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
                                <div class="mt-2"> <span class="badge bg-secondary mt-2">مشترك بالفعل</span>
                                </div>
                            @endif
                        @endrole
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
