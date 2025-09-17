<x-dash-layout>
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
                                {{-- زر عرض --}}
                                <a href="{{ route('user.show-cources', $course->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
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
