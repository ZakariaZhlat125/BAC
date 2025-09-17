@props(['chapter' => null, 'courses' => []])

<div class="col-md-6">
    <label class="form-label">عنوان الفصل</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $chapter->title ?? '') }}">
</div>

<div class="col-md-6">
    <label class="form-label">المقرر</label>
    <select name="course_id" class="form-control">
        <option value="">-- اختر مقرر --</option>
        @foreach ($courses as $course)
            <option value="{{ $course->id }}"
                {{ old('course_id', $chapter->course_id ?? '') == $course->id ? 'selected' : '' }}>
                {{ $course->title }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-12">
    <label class="form-label">الوصف</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $chapter->description ?? '') }}</textarea>
</div>
