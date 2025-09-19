@props(['chapter'])
<form x-ref="videoForm" method="POST" action="{{ route('user.contents.store') }}" class="row g-3"
    enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
    <input type="hidden" name="type" value="explain">

    <div class="d-flex w-100 justify-content-end p-2">
        <button type="button" @click="back('videoWrapper')" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> رجوع
        </button>
    </div>

    <div class="col-md-6">
        <label class="form-label">عنوان المحتوى</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">ملف الفيديو </label>
        <input type="file" name="video" class="form-control" accept="video/*" required>
    </div>


    <div class="col-md-6">
        <label class="form-label">ملف (اختياري)</label>
        <input type="file" name="file" class="form-control">
    </div>

    <div class="col-12">
        <label class="form-label">الوصف</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="col-12 text-end mt-3">
        <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-floppy-disk me-1"></i> حفظ
        </button>
    </div>
</form>
