@props(['chapter'])

<form x-ref="videoForm" method="POST" action="{{ route('user.contents.store') }}" class="row g-3"
    enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
    <input type="hidden" name="type" value="explain">

    {{-- 🔹 زر الرجوع --}}
    <div class="d-flex w-100 justify-content-end p-2">
        <button type="button" @click="back('videoWrapper')" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> رجوع
        </button>
    </div>

    {{-- 🔹 عنوان المحتوى --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">عنوان المحتوى <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title') }}" required>
        @error('title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- 🔹 ملف الفيديو (إجباري + أنواع محددة) --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">ملف الفيديو <span class="text-danger">*</span></label>
        <input type="file" name="video" class="form-control @error('video') is-invalid @enderror"
            accept=".mp4,.avi,.mov,.mkv" required>
        <small class="text-muted">الملفات المسموحة: mp4, avi, mov, mkv</small>
        @error('video')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    {{-- 🔹 ملف إضافي (اختياري + أنواع محددة) --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">ملف إضافي (اختياري)</label>
        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
            accept=".pdf,.docx,.pptx,.txt">
        <small class="text-muted">الملفات المسموحة: pdf, docx, pptx, txt</small>
        @error('file')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    {{-- 🔹 الوصف --}}
    <div class="col-12">
        <label class="form-label fw-semibold">الوصف</label>
        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
        @error('description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- 🔹 زر الحفظ --}}
    <div class="col-12 text-end mt-3">
        <button type="submit" class="btn btn-success px-4">
            <i class="fa-solid fa-floppy-disk me-1"></i> حفظ
        </button>
    </div>
</form>
