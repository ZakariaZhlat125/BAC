<x-modal id="notificationsModal" title="التنبيهات" maxWidth="lg">
    @forelse ($notifications as $notification)
        <div class="notification card-body d-flex align-items-start mb-2">
            @php
                $type = $notification->data['type'] ?? 'info';
                $title = $notification->data['title'] ?? 'إشعار';
                $body = $notification->data['message'] ?? '';
                $time = $notification->created_at->diffForHumans();
            @endphp

            {{-- <img src="{{ asset('assets/img/' . $type . '.png') }}" class="btn_icon me-2"> --}}
            <div class="text text-end">
                <strong>{{ $title }}</strong> - {{ $body }}
                <div class="time text-muted">منذ {{ $time }}</div>
            </div>
        </div>
    @empty
        <h4 class="text-center">لايوجد تنبيهات لعرضها</h4>
    @endforelse
</x-modal>


