@props(['event' => null])

<div class="col-md-6">
    <label class="form-label">اسم الحدث</label>
    <input type="text" name="event_name" class="form-control" value="{{ old('event_name', $event->event_name ?? '') }}">
</div>

<div class="col-md-6">
    <label class="form-label">تاريخ الحدث</label>
    <input type="date" name="event_date" class="form-control"
        value="{{ old('event_date', $event->event_date ?? '') }}">
</div>

<div class="col-md-6">
    <label class="form-label">المكان</label>
    <input type="text" name="location" class="form-control" value="{{ old('location', $event->location ?? '') }}">
</div>

<div class="col-md-6">
    <label class="form-label">الحضور</label>
    <input type="text" name="attendees" class="form-control" value="{{ old('attendees', $event->attendees ?? '') }}">
</div>

<div class="col-12">
    <label class="form-label">الوصف</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $event->description ?? '') }}</textarea>
</div>

<div class="col-12">
    <label class="form-label">رفع صورة</label>
    <input type="file" name="attach" class="form-control" accept="image/jpeg,image/jpg,image/png">

    @if (!empty($event?->attach))
        <div class="mt-2">
            <a href="{{ asset('storage/' . $event->attach) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                عرض الصورة الحالية
            </a>
        </div>
    @endif
</div>
