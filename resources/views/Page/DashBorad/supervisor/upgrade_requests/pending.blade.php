<x-dash-layout>
    <div class="container mt-4">
        <h4 class="mb-3">طلبات الترقية المعلقة</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                @if ($data->isNotEmpty())
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>الحالة</th>
                            <th>السبب</th>
                            <th>المرفق</th>
                            <th>تخصص الطالب</th>
                            <th>النقاط</th>
                            <th>السنة</th>
                            <th>السيرة الذاتية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @forelse ($data as $req)
                        <tr>
                            <td>{{ $req->id }}</td>
                            <td>
                                <span
                                    class="badge
                                    @if ($req->status === 'pending') bg-warning
                                    @elseif($req->status === 'approved') bg-success
                                    @else bg-danger @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td>{{ $req->reason }}</td>
                            <td>
                                @if ($req->attach_file)
                                    <a href="{{ asset('storage/' . $req->attach_file) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $req->attach_file) }}" alt="المرفق"
                                            style="width:60px; height:60px; object-fit:cover;">
                                    </a>
                                @else
                                    <span class="text-muted">لا يوجد ملف</span>
                                @endif
                            </td>
                            <td>{{ $req->student->major ?? '-' }}</td>
                            <td>{{ $req->student->points ?? '-' }}</td>
                            <td>{{ $req->student->year ?? '-' }}</td>
                            <td>{{ $req->student->bio ?? '-' }}</td>
                            <td class="d-flex justify-content-center gap-1">
                                <!-- زر عرض -->
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#viewModal{{ $req->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- زر تحديث الحالة -->
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#statusModal{{ $req->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- زر الحذف -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $req->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- مودال العرض -->
                        <x-modal id="viewModal{{ $req->id }}" title="تفاصيل الطلب" maxWidth="lg">
                            <p><strong>السبب:</strong> {{ $req->reason }}</p>
                            <p><strong>الحالة:</strong> {{ ucfirst($req->status) }}</p>
                            <p><strong>تخصص الطالب:</strong> {{ $req->student->major ?? '-' }}</p>
                            <p><strong>النقاط:</strong> {{ $req->student->points ?? '-' }}</p>
                            <p><strong>السنة:</strong> {{ $req->student->year ?? '-' }}</p>
                            <p><strong>السيرة الذاتية:</strong> {{ $req->student->bio ?? '-' }}</p>
                            @if ($req->attach_file)
                                <p><strong>المرفق:</strong></p>
                                <img src="{{ asset('storage/' . $req->attach_file) }}"
                                    style="width:100%; max-height:400px; object-fit:cover;">
                            @endif
                        </x-modal>

                        <!-- مودال تحديث الحالة -->
                        <x-modal id="statusModal{{ $req->id }}" title="تحديث حالة الطلب" maxWidth="md">
                            <form action="{{ route('supervisor.upgrade-requests.update-status', $req->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="status{{ $req->id }}" class="form-label">الحالة</label>
                                    <select name="status" id="status{{ $req->id }}" class="form-select" required>
                                        <option value="pending" @if ($req->status == 'pending') selected @endif>
                                            قيد الانتظار</option>
                                        <option value="approved" @if ($req->status == 'approved') selected @endif>
                                            موافق عليه</option>
                                        <option value="rejected" @if ($req->status == 'rejected') selected @endif>
                                            مرفوض</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-success">تحديث</button>
                                </div>
                            </form>
                        </x-modal>

                        <!-- مودال الحذف -->
                        <x-modal id="deleteModal{{ $req->id }}" title="تأكيد الحذف" maxWidth="md">
                            <form action="{{ route('supervisor.upgrade-requests.destroy', $req->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <p class="mb-3">هل أنت متأكد أنك تريد حذف هذا الطلب؟</p>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </div>
                            </form>
                        </x-modal>

                    @empty
                        <tr>
                            <td colspan="9" class="text-muted">لا توجد طلبات ترقية.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-dash-layout>
