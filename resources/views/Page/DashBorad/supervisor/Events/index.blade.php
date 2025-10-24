<x-dash-layout>

    {{-- زر فتح المودال للإضافة --}}
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
            <i class="fa-solid fa-plus-circle me-1"></i> إضافة حدث جديد
        </button>
    </div>

    {{-- المودال الخاص بإنشاء حدث --}}
    <x-modal id="eventModal" title="إضافة حدث جديد" maxWidth="lg">
        <form method="POST" action="{{ route('supervisor.events.store') }}" enctype="multipart/form-data"
            class="row g-3">
            @csrf
            @include('components.event-form')
            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk me-1"></i> حفظ
                </button>
            </div>
        </form>
    </x-modal>

    {{-- جدول عرض الأحداث --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            قائمة الأحداث
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم الحدث</th>
                        <th>التاريخ</th>
                        <th>المكان</th>
                        <th>الحضور</th>
                        <th>الوصف</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->event_date }}- {{ $event->event_time }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ $event->attendees }}</td>
                            <td>{{ Str::limit($event->description, 50) }}</td>
                            <td>
                                {{-- زر فتح المودال للتعديل --}}
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editEventModal{{ $event->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                {{-- مودال التعديل --}}
                                <x-modal id="editEventModal{{ $event->id }}" title="تعديل الحدث" maxWidth="lg">
                                    <form method="POST" action="{{ route('supervisor.events.update', $event->id) }}"
                                        class="row g-3" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        @include('components.event-form', ['event' => $event])
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa-solid fa-floppy-disk me-1"></i> تحديث
                                            </button>
                                        </div>
                                    </form>
                                </x-modal>
                                <a href="{{ route('supervisor.events.show', $event->id) }}"
                                    class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                {{-- زر فتح المودال للحذف --}}
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteEventModal{{ $event->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                {{-- مودال الحذف --}}
                                <x-modal id="deleteEventModal{{ $event->id }}" title="تأكيد الحذف" maxWidth="sm">
                                    <div class="text-center py-3">
                                        <p>هل أنت متأكد أنك تريد حذف الحدث <strong>{{ $event->event_name }}</strong>؟
                                        </p>
                                        <form action="{{ route('supervisor.events.destroy', $event->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa-solid fa-trash me-1"></i> نعم، احذف
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">إلغاء</button>
                                    </div>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">لا توجد أحداث حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-dash-layout>
