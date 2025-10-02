@props(['countEvents', 'countStudents'])


<h2 class="section-title">البيانات المفتوحة</h2>

<div class="container my-4">
    <div class="card shadow-sm p-4 rounded-3" style="background-color: white; border-radius: 15px;">
        <div class="row text-center">

            <!-- الفعاليات -->

            <div class="col-6 col-md-6 mb-3 mb-md-0">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <img src="assets/img/ic_activities_2.png" style="width: 80px; height: 80px;">
                    <div class="text-center">
                        <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                            الفعاليات</h6>
                        <span class="text-warning fw-semibold"
                            style="color: var(--kuf-gold); font-size: 24px;">{{ $countEvents }}</span>
                    </div>
                </div>
            </div>

            {{-- <!-- المحتوى التعليمي -->
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <img src="assets/img/ic_media.png" style="width: 80px; height: 80px;">

                    <div class="text-center">
                        <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                            المحتوى
                            التعليمي</h6>
                        <span class="text-warning fw-semibold"
                            style="color: var(--kuf-gold); font-size: 24px;">300</span>
                    </div>
                </div>
            </div> --}}

            <!-- الطلاب النشطين -->
            <div class="col-6 col-md-6 mb-3 mb-md-0">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <img src="assets/img/ic_active_std.png" style="width: 80px; height: 80px;">
                    <div class="text-center">

                        <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                            الطلاب
                            النشطين</h6>
                        <span class="text-warning fw-semibold"
                            style="color: var(--kuf-gold); font-size: 24px;">{{ $countStudents }}</span>
                    </div>
                </div>
            </div>


            <!-- الزوار -->
            {{-- <div class="col-6 col-md-3 mb-3 mb-md-0">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <img src="assets/img/ic_visitors.png" style="width: 80px; height: 80px;">
                    <div class="text-center">

                        <h6 class="fw-bold mt-2 text-teal" style="color: var(--kfu-dark); font-size: 24px;">
                            الزوار
                        </h6>
                        <span class="text-warning fw-semibold"
                            style="color: var(--kuf-gold); font-size: 24px;">1500</span>
                    </div>
                </div>

            </div> --}}
        </div>
    </div>
</div>
