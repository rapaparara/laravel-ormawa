@if (flash()->message)
    <div class="px-4 py-2 mb-3 text-sm rounded-lg {{ flash()->class ?? 'bg-green-50 text-green-800' }}" role="alert">
        {{ flash()->message }}
    </div>
@endif
