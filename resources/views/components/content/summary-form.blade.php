@props(['chapter'])

<form x-ref="summaryForm" method="POST" action="{{ route('user.contents.store') }}" class="row g-3"
    enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
    <input type="hidden" name="type" value="summary">

    {{-- 🔹 زر الرجوع --}}
    <div class="d-flex w-100 justify-content-end p-2">
        <button type="button" @click="back('summaryWrapper')" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> رجوع
        </button>
    </div>

    {{-- 🔹 العنوان --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">عنوان المحتوى <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title') }}" required>
        @error('title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- 🔹 الملف (إجباري + أنواع محددة) --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold">الملف <span class="text-danger">*</span></label>
        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
            accept=".pdf, .docx, .pptx, .txt" required>
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
    <div class="col-6 text-end mt-3">
        <button type="submit" class="btn btn-success px-4">
            <i class="fa-solid fa-floppy-disk me-1"></i> حفظ
        </button>
    </div>

</form>
