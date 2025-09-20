<x-dash-layout>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Students List</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Major</th>
                            <th>Year</th>
                            <th>Points</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ optional($user->student)->major }}</td>
                                <td>{{ optional($user->student->yearRelation)->name }}</td>
                                <td>{{ optional($user->student)->points }}</td>
                                <td>
                                    <!-- Delete Button (opens modal) -->
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteStudentModal{{ $user->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    {{-- Delete Modal --}}
                                    <x-modal id="deleteStudentModal{{ $user->id }}" title="تأكيد الحذف"
                                        maxWidth="sm">
                                        <div class="text-center py-3">
                                            <p>
                                                هل أنت متأكد أنك تريد حذف الطالب
                                                <strong>{{ $user->name }}</strong>؟
                                            </p>

                                            <form action="{{ route('admin.students.destroy', $user->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash me-1"></i> نعم، احذف
                                                </button>
                                            </form>

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                إلغاء
                                            </button>
                                        </div>
                                    </x-modal>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dash-layout>
