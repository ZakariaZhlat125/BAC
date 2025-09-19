@props(['chapter'])

<!-- ضع هذا فقط مرة في الـ layout إذا Alpine غير محمّل -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="contentSwitcher()" class="p-3">

    <!-- شاشة الأزرار (تظهر أولاً) -->
    <div x-show="step === 'choose'" x-cloak class="text-center">
        <button type="button" @click="open('explain')" class="btn btn-warning fw-bold me-2">
            <i class="fa-solid fa-video me-1"></i> شرح
        </button>
        <button type="button" @click="open('summary')" class="btn btn-info fw-bold">
            <i class="fa-solid fa-file-lines me-1"></i> ملخص
        </button>
    </div>

    <!-- فورم الشرح -->
    <div x-show="step === 'explain'" x-cloak class="mt-3">
        <!-- لو داخل الفيديو فورم حطيت x-ref على الفورم نفسه (مو ضروري لو تستخدم back() للبحث عن الفورم داخل العنصر) -->
        <div x-ref="videoWrapper">
            <x-content.video-form :chapter="$chapter" />
        </div>
    </div>

    <!-- فورم الملخص -->
    <div x-show="step === 'summary'" x-cloak class="mt-3">
        <div x-ref="summaryWrapper">
            <x-content.summary-form :chapter="$chapter" />
        </div>


    </div>
</div>

<script>
    function contentSwitcher() {
        return {
            step: 'choose', // 'choose' | 'explain' | 'summary'
            open(type) {
                // type = 'explain' or 'summary'
                this.step = type;
                // optional: focus first input after nextTick
                this.$nextTick(() => {
                    const wrapper = (type === 'explain') ? this.$refs.videoWrapper : this.$refs.summaryWrapper;
                    if (wrapper) {
                        const first = wrapper.querySelector('input,textarea,select,button');
                        if (first) first.focus();
                    }
                });
            },
            back(wrapperRefName) {
                // إرجاع للشاشة الرئيسية + إعادة تهيئة الفورم داخل wrapper
                this.step = 'choose';
                this.$nextTick(() => {
                    // حاول إيجاد الفورم داخل الـ wrapper وإعادة تهيئته
                    const wrapper = this.$refs[wrapperRefName];
                    if (!wrapper) return;
                    // إذا الـ wrapper هو الفورم نفسه أو يحتوي على الفورم:
                    if (wrapper.tagName === 'FORM' && typeof wrapper.reset === 'function') {
                        wrapper.reset();
                    } else {
                        const form = wrapper.querySelector('form');
                        if (form && typeof form.reset === 'function') form.reset();
                        // إن أردت مسح أخطاء العرض (مثلاً عناصر خطأ تظهر عبر JS) يمكنك إضافتها هنا
                    }
                });
            }
        }
    }
</script>
