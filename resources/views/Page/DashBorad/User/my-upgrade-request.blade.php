<x-dash-layout>
    <div class="container mt-4">
        <h4 class="mb-3">طلب الترقية الخاص بي</h4>

        @if ($data)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>طلب الترقية #{{ $data->id }}</span>
                    <span
                        class="badge
            @if ($data->status === 'pending') bg-warning
            @elseif($data->status === 'approved') bg-success
            @else bg-danger @endif">
                        {{ ucfirst($data->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <p><strong>السبب:</strong> {{ $data->reason }}</p>
                    <p><strong>تخصص الطالب:</strong> {{ $data->student->major ?? '-' }}</p>
                    <p><strong>النقاط:</strong> {{ $data->student->points ?? '-' }}</p>
                    <p><strong>السنة:</strong> {{ $data->student->year ?? '-' }}</p>
                    <p><strong>السيرة الذاتية:</strong> {{ $data->student->bio ?? '-' }}</p>
                    @if ($data->attach_file)
                        <p><strong>المرفق:</strong></p>
                        <a href="{{ asset('storage/' . $data->attach_file) }}" target="_blank">
                            <img src="{{ asset('storage/' . $data->attach_file) }}"
                                style="width:100%; max-height:300px; object-fit:cover;" alt="المرفق">
                        </a>
                    @endif
                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                            data-bs-target="#viewModal{{ $data->id }}">
                            عرض التفاصيل
                        </button>
                    </div>
                </div>
            </div>

            <!-- مودال العرض -->
            <x-modal id="viewModal{{ $data->id }}" title="تفاصيل الطلب" maxWidth="lg">
                <p><strong>السبب:</strong> {{ $data->reason }}</p>
                <p><strong>الحالة:</strong> {{ ucfirst($data->status) }}</p>
                <p><strong>تخصص الطالب:</strong> {{ $request->student->major ?? '-' }}</p>
                <p><strong>النقاط:</strong> {{ $data->student->points ?? '-' }}</p>
                <p><strong>السنة:</strong> {{ $data->student->year ?? '-' }}</p>
                <p><strong>السيرة الذاتية:</strong> {{ $data->student->bio ?? '-' }}</p>
                @if ($data->attach_file)
                    <p><strong>المرفق:</strong></p>
                    <img src="{{ asset('storage/' . $data->attach_file) }}"
                        style="width:100%; max-height:400px; object-fit:cover;" alt="المرفق">
                @endif
            </x-modal>
        @else
            <div class="alert alert-info">لا يوجد طلب ترقية.</div>
        @endif
    </div>
</x-dash-layout>
