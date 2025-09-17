@props(['course' => null, 'specializations' => [], 'years' => []])

<div class="col-md-6">
    <label class="form-label">اسم المقرر</label>
    <input type="text" name="title" class="form-control"
        value="{{ old('title', $course->title ?? '') }}">
</div>

<div class="col-md-6">
    <label class="form-label">الفصل الدراسي</label>
    <input type="text" name="semester" class="form-control"
        value="{{ old('semester', $course->semester ?? '') }}">
</div>

<div class="col-md-6">
    <label class="form-label">السنة</label>
    <select name="year_id" class="form-control">
        <option value="">-- اختر سنة --</option>
        @foreach($years as $year)
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
        @foreach($specializations as $specialization)
            <option value="{{ $specialization->id }}"
                {{ old('specialization_id', $course->specialization_id ?? '') == $specialization->id ? 'selected' : '' }}>
                {{ $specialization->title }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-12">
    <label class="form-label">الوصف</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $course->description ?? '') }}</textarea>
</div>
