<x-dash-layout>

    {{-- زر فتح المودال للإضافة --}}
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#courseModal">
            <i class="fa-solid fa-plus-circle me-1"></i> إضافة مقرر جديد
        </button>
    </div>

    {{-- مودال إنشاء مقرر جديد --}}
    <x-modal id="courseModal" title="إضافة مقرر جديد" maxWidth="lg">
        <form method="POST" action="{{ route('supervisor.courses.store') }}" class="row g-3">
            @csrf
            @include('components.course-form')
            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk me-1"></i> حفظ
                </button>
            </div>
        </form>
    </x-modal>
    @foreach ($courses as $course)
        {{ $course->specialization }}
    @endforeach
    {{-- جدول عرض المقررات --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            قائمة المقررات
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>اسم المقرر</th>
                        <th>الفصل الدراسي</th>
                        <th>السنة</th>
                        <th>التخصص</th>
                        <th>الوصف</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse ($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->semester }}</td>
                            <td>{{ $course->year->name ?? '-' }}</td>
                            <td>{{ $course->specializ->title ?? '-' }}</td>
                            <td>{{ Str::limit($course->description, 50) }}</td>
                            <td>
                                {{-- زر فتح المودال للتعديل --}}
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editCourseModal{{ $course->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                {{-- مودال التعديل --}}
                                <x-modal id="editCourseModal{{ $course->id }}" title="تعديل المقرر" maxWidth="lg">
                                    <form method="POST" action="{{ route('supervisor.courses.update', $course->id) }}"
                                        class="row g-3">
                                        @csrf
                                        @method('PUT')
                                        @include('components.course-form', ['course' => $course])
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa-solid fa-floppy-disk me-1"></i> تحديث
                                            </button>
                                        </div>
                                    </form>
                                </x-modal>

                                {{-- زر عرض --}}
                                <a href="{{ route('supervisor.courses.show', $course->id) }}"
                                    class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                {{-- زر الحذف --}}
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteCourseModal{{ $course->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                {{-- مودال الحذف --}}
                                <x-modal id="deleteCourseModal{{ $course->id }}" title="تأكيد الحذف" maxWidth="sm">
                                    <div class="text-center py-3">
                                        <p>هل أنت متأكد أنك تريد حذف المقرر <strong>{{ $course->title }}</strong>؟</p>
                                        <form action="{{ route('supervisor.courses.destroy', $course->id) }}"
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
                            <td colspan="7" class="text-center text-muted py-3">لا توجد مقررات حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-dash-layout>
