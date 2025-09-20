<x-dash-layout>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">قائمة المشرفين</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>التخصص</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supervisors as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{ optional($user->supervisor->specializ)->title ?? '—' }}
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '—' }}</td>
                            <td>
                                <!-- Delete Button -->
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteSupervisorModal{{ $user->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <!-- Delete Modal -->
                                <x-modal id="deleteSupervisorModal{{ $user->id }}" title="تأكيد الحذف" maxWidth="sm">
                                    <div class="text-center py-3">
                                        <p>
                                            هل أنت متأكد أنك تريد حذف المشرف
                                            <strong>{{ $user->name }}</strong>؟
                                        </p>

                                        <form action="{{ route('admin.supervisors.destroy', $user->id) }}"
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
                            <td colspan="6" class="text-center">لا يوجد مشرفين</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $supervisors->links() }}
            </div>
        </div>
    </div>
</div>

</x-dash-layout>
