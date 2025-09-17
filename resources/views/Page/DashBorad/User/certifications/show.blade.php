<x-dash-layout>
    <div class="d-flex gap-2">

        {{-- زر إصدار شهادة --}}
        <form action="{{ route('user.certifications.issue', $student->id) }}" method="POST">
            @csrf
            <button class="btn btn-primary">إصدار شهادة</button>
        </form>

        {{-- زر طباعة الشهادة (إذا الطالب عنده شهادة) --}}
        @if (isset($certification))
            <a href="{{ route('user.certifications.print', $certification->id) }}" target="_blank" class="btn btn-success">
                <i class="fa fa-print"></i> طباعة الشهادة
            </a>
        @endif

    </div>
</x-dash-layout>
