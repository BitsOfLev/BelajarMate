@props(['action', 'confirmMessage' => 'Are you sure you want to remove this connection?'])

<form action="{{ $action }}" 
      method="POST" 
      onsubmit="return confirm('{{ $confirmMessage }}');"
      class="d-inline">
    @csrf
    @method('POST') {{-- Recommended for "remove" actions --}}
    
    <button type="submit" 
            {{ $attributes->merge(['class' => 'bm-btn bm-btn-cancel-req']) }}
            style="font-size:0.85rem;">
        {{ $slot->isEmpty() ? 'Remove' : $slot }}
    </button>
</form>
