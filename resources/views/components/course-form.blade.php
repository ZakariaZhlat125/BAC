@props(['course' => null, 'specializations' => [], 'years' => []])

<div class="col-md-6">
    <label class="form-label">اسم المقرر</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $course->title ?? '') }}">
</div>
{{-- 🔹 الفصل الدراسي (اختيار أول أو ثاني) --}}
<div class="col-md-6">
    <label class="form-label">الفصل الدراسي</label>
    <select name="semester" class="form-control">
        <option value="">-- اختر الفصل --</option>
        <option value="الأول" {{ old('semester', $course->semester ?? '') == 'الأول' ? 'selected' : '' }}>الفصل الأول
        </option>
        <option value="الثاني" {{ old('semester', $course->semester ?? '') == 'الثاني' ? 'selected' : '' }}>الفصل الثاني
        </option>
    </select>
</div>


<div class="col-md-6">
    <label class="form-label">السنة</label>
    <select name="year_id" class="form-control">
        <option value="">-- اختر سنة --</option>
        @foreach ($years as $year)
            <option value="{{ $year->id }}"
                {{ old('year_id', $course->year_id ?? '') == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-6">
    <label class="form-label">التخصص</label>
    <select name="specialization_id" class="form-control">
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
        value="{{ old('difficulty', $course->difficulty ?? '') }}">
</div>

<div class="col-12">
    <label class="form-label">الوصف</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $course->description ?? '') }}</textarea>
</div>
