@php
    $replace_points = $points - ($points % 100);
@endphp

<x-modal id="pointsConversionModal" title="طلب احتساب ساعات تطوعية باستخدام النقاط" maxWidth="lg">
    <p>سيتم إرسال طلبك إلى مشرفك الحالي:</p>
    <p>{{ $supervisorName }}</p>

    <div class="card p-2 mb-2 bg-light">
        <div class="row">
            <div class="col-4">
                <p class="form-label">عدد النقاط</p>
                <p class="fw-bold fs-5">{{ $points }} <span class="fs-6">نقطة</span></p>
            </div>
            <div class="col-8">
                <p class="form-label">ادخل عدد النقاط التي تريد احتسابها</p>
                <p class="form-label">يسمح فقط بمضاعفات 100</p>
                <p>
                    <span class="status bg-secondary px-2">{{ $replace_points }}</span>
                    <span class="fs-2"> = </span>
                    <span class="status bg-secondary px-2">{{ $replace_points / 100 }}</span>
                    <span class="fs-6"> ساعات تطوعية </span>
                </p>
                <p>سيكون رصيدك من النقاط = {{ $points % 100 }}</p>
            </div>
        </div>
    </div>

    <div class="card p-2 mb-2" style="background-color: #7FA9A9;">
        <p class="text-white fs-6 text-end">
            كل ساعة تطوعية واحدة = 100 نقطة. الرجاء التأكد من رغبتك بالاستبدال.
        </p>
    </div>

    <div class="mb-3 form-check text-end">
        <input type="checkbox" class="form-check-input ms-2" id="agree">
        <label for="agree" class="form-check-label fs-6">
            أتعهد أنني متأكد من استبدال النقاط، وأوافق على أن العملية نهائية ولا يمكن التراجع عنها بعد احتسابها
        </label>
    </div>

    <div class="row mb-3">
        <div class="col-3">
            <button type="submit" class="btn btn-kfu">تأكيد الاحتساب</button>
        </div>
        <div class="col-2">
            <button class="btn btn-kfu btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        </div>
        <div class="col-7">
            <p class="fs-6 text-end">رصيدك الحالي من النقاط: {{ $points }} نقطة</p>
        </div>
    </div>

    <x-slot:footer>
        <ul class="fs-6">
            <span class="note-title">ملاحظات</span>
            <li>لا يتم الخصم إلا بعد موافقتك الصريحة عبر التعهد.</li>
            <li>يمكن لفريق الإشراف مراجعة الطلب خلال 24–48 ساعة عمل.</li>
            <li>سيصلك إشعار بحالة الطلب عبر البريد الجامعي أو لوحة الإشعارات.</li>
        </ul>
    </x-slot:footer>
</x-modal>
