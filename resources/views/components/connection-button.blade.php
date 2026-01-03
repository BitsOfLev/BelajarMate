@if(!$connection)
    <!-- Connect -->
    @if($user)
    <form method="POST" action="{{ route('connections.send') }}">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <button type="submit" class="bm-btn bm-btn-connect {{ $buttonClass }}">
            Connect
        </button>
    </form>
    @endif

@elseif($isPending && $isSentByMe)
    <!-- Cancel Request -->
    <form method="POST" action="{{ route('connections.remove', $connection->connectionID) }}"
          onsubmit="return confirm('Are you sure you want to cancel this request?');">
        @csrf
        <button type="submit" class="bm-btn bm-btn-cancel-req {{ $buttonClass }}">
            Cancel Request
        </button>
    </form>

@elseif($isPending && $isReceivedByMe)
    <!-- Accept / Reject -->
    <div class="d-flex gap-2 {{ $buttonClass }}">
        <form method="POST" action="{{ route('connections.accept', $connection->connectionID) }}">
            @csrf
            <button type="submit" class="btn text-white rounded-pill px-3 py-1 fw-semibold"
                    style="background-color:#8c52ff;font-size:0.85rem;">Accept</button>
        </form>
        <form method="POST" action="{{ route('connections.reject', $connection->connectionID) }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger rounded-pill px-3 py-1 fw-semibold"
                    style="font-size:0.85rem;">Reject</button>
        </form>
    </div>

@elseif($isAccepted)
    <!-- Remove Connection -->
    <x-remove-connection-button :action="route('connections.remove', $connection->connectionID)" />
@endif

