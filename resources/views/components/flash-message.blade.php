@if (flash()->message)
    @if (session('user_role') !== null)
        <div wire:click="editStateModal()"
            class="px-4 py-2 mb-3 text-sm rounded-lg {{ flash()->class ?? 'bg-green-50 text-green-800' }}" role="alert">
            {{ flash()->message }}
        </div>
    @else
        <div class="px-4 py-2 mb-3 text-sm rounded-lg {{ flash()->class ?? 'bg-green-50 text-green-800' }}"
            role="alert">
            {{ flash()->message }}
        </div>
    @endif
@endif
