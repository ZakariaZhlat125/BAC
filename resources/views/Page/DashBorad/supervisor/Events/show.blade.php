<x-dash-layout>
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white fw-bold">
            تفاصيل الحدث
        </div>
        <div class="d-flex ">

            <div class="card-body">
            <p><strong>اسم الحدث:</strong> {{ $event->event_name }}</p>
            <p><strong>التاريخ:</strong> {{ $event->event_date }}</p>
            <p><strong>المكان:</strong> {{ $event->location }}</p>
            <p><strong>الحضور:</strong> {{ $event->attendees }}</p>
            <p><strong>الوصف:</strong> {{ $event->description }}</p>
            <p>
                <strong>المرفق:</strong>
                @if ($event->attach)
                    <a href="{{ asset('storage/' . $event->attach) }}" target="_blank"
                        class="btn btn-sm btn-outline-primary">
                        تحميل
                    </a>
                @else
                    لا يوجد
                @endif
            </p>

        </div>
        {{-- نموذج منح النقاط --}}
        <div class="card-body border-top">
            <h5 class="fw-bold mb-3">منح نقاط للمشاركين</h5>
            <form action="{{ route('supervisor.events.updateStatus', $event->id) }}" method="POST">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <label class="form-label">عدد النقاط</label>
                        <input type="number" name="points" class="form-control" min="1" max="100"
                            value="5">
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-success mt-4">
                            <i class="fa-solid fa-star"></i> منح النقاط للطلاب
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>


        {{-- قسم المشاركات --}}
        @if ($event->participations && $event->participations->count() > 0)
            <div class="card-body border-top">
                <h5 class="fw-bold mb-3">المشاركات</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>الصف</th>
                            <th>النقاط</th>
                            <th>الحالة</th>
                            <th>التغذية الراجعة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->participations as $participation)
                            <tr>
                                <td>{{ $participation->id }}</td>
                                <td>{{ $participation->student->user->name ?? 'غير متوفر' }}</td>
                                <td>{{ $participation->student->year ?? '-' }}</td>
                                <td>{{ $participation->student->points ?? 0 }}</td>
                                <td>
                                    @if ($participation->attendance_status === 'active')
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $participation->attendance_status }}</span>
                                    @endif
                                </td>
                                <td>{{ $participation->feedback ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-body border-top text-muted">
                لا توجد مشاركات حتى الآن.
            </div>
        @endif

        <div class="card-footer text-end">
            <a href="{{ route('supervisor.events.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> عودة
            </a>
        </div>
    </div>
</x-dash-layout>
