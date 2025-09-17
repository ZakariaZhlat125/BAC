@props([
    'id' => 'modal',
    'title' => 'Modal Title',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
    $maxWidthClasses = [
        'sm' => 'modal-sm',
        'md' => 'modal-md',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        '2xl' => 'modal-xxl'
    ];
    $modalWidthClass = $maxWidthClasses[$maxWidth] ?? 'modal-xxl';
@endphp

<div class="modal fade @if($show) show @endif" id="{{ $id }}" tabindex="-1" aria-hidden="true" @if($show) style="display: block;" @endif>
    <div class="modal-dialog modal-dialog-centered {{ $modalWidthClass }}">
        <div class="modal-content text-end">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" style="width: 100%;">{{ $title }}</h5>
                <img src="{{ asset('assets/img/ic_exit.png') }}" style="width: 15px; height: 15px;" alt="إغلاق"
                     data-bs-dismiss="modal" aria-label="إغلاق">
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                {{ $slot }}
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="justify-content: flex-end;">
                {{ $footer ?? '' }}
            </div>

        </div>
    </div>
</div>
