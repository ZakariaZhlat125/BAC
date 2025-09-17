@props(['value'])

<label {{ $attributes->merge(['class' => class="form-label text-white"]) }}>
    {{ $value ?? $slot }}
</label>
