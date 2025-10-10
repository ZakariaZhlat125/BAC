@props(['course' => null, 'specializations' => [], 'years' => []])

<style>
    .form-section {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        padding: 25px;
        transition: all 0.3s ease;
    }

    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #0d6efd;
    }

    .preview-img {
        max-width: 200px;
        height: auto;
        display: none;
        border-radius: 8px;
        margin-top: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>

{{-- 🔹 اسم المقرر --}}
<div class="col-md-6">
    <label class="form-label">اسم المقرر</label>
    <input type="text" name="title" class="form-control" placeholder="أدخل اسم المقرر"
        value="{{ old('title', $course->title ?? '') }}">
</div>

{{-- 🔹 الفصل الدراسي --}}
<div class="col-md-6">
    <label class="form-label">الفصل الدراسي</label>
    <select name="semester" class="form-select">
        <option value="">-- اختر الفصل --</option>
        <option value="الأول" {{ old('semester', $course->semester ?? '') == 'الأول' ? 'selected' : '' }}>الفصل
            الأول</option>
        <option value="الثاني" {{ old('semester', $course->semester ?? '') == 'الثاني' ? 'selected' : '' }}>الفصل
            الثاني</option>
    </select>
</div>

{{-- 🔹 السنة --}}
<div class="col-md-6">
    <label class="form-label">السنة</label>
    <select name="year_id" class="form-select">
        <option value="">-- اختر سنة --</option>
        @foreach ($years as $year)
            <option value="{{ $year->id }}"
                {{ old('year_id', $course->year_id ?? '') == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- 🔹 التخصص --}}
<div class="col-md-6">
    <label class="form-label">التخصص</label>
    <select name="specialization_id" class="form-select">
        <option value="">-- اختر تخصص --</option>
        @foreach ($specializations as $specialization)
            <option value="{{ $specialization->id }}"
                {{ old('specialization_id', $course->specialization_id ?? '') == $specialization->id ? 'selected' : '' }}>
                {{ $specialization->title }}
            </option>
        @endforeach
    </select>
</div>

{{-- 🔹 مدى الصعوبة --}}
<div class="col-md-6">
    <label class="form-label">مدى الصعوبة (1 - 10)</label>
    <input type="number" name="difficulty" class="form-control" min="1" max="10"
        placeholder="أدخل درجة الصعوبة" value="{{ old('difficulty', $course->difficulty ?? '') }}">
</div>

{{-- 🔹 رفع صورة المقرر --}}
<div class="col-md-6">
    <label class="form-label">صورة المقرر</label>
    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
    <img id="imagePreview" class="preview-img mt-2"
        src="{{ isset($course->image) ? asset('storage/' . $course->image) : '' }}"
        @if (isset($course->image)) style="display:block;" @endif alt="Course Image Preview">
</div>

{{-- 🔹 الوصف --}}
<div class="col-12">
    <label class="form-label">الوصف</label>
    <textarea name="description" rows="3" class="form-control" placeholder="أدخل وصف المقرر">{{ old('description', $course->description ?? '') }}</textarea>
</div>

{{-- 🔹 عرض الصورة المرفوعة --}}
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById('imagePreview');
        reader.onload = function() {
            imageField.src = reader.result;
            imageField.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
