<!-- ========================== -->
<!-- CONNECTIONS TAB -->
<!-- ========================== -->
<div class="tab-pane fade" id="connections" role="tabpanel">
    <div class="card p-4 shadow-sm mb-4 border-0 rounded-4">

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif 

        <!-- Tabs -->
        <ul class="nav nav-pills mb-3" id="connectionSubTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="connected-tab" data-bs-toggle="tab" data-bs-target="#connected" type="button" role="tab">
                    Connected ({{ $accepted->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent" type="button" role="tab">
                    Sent Requests ({{ $sent->count() }})
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="incoming-tab" data-bs-toggle="tab" data-bs-target="#incoming" type="button" role="tab">
                    Incoming Requests ({{ $incoming->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- CONNECTED -->
            <div class="tab-pane fade show active" id="connected" role="tabpanel">
                @forelse($accepted as $connection)
                    @php
                        // Determine the other user in the connection
                        $otherUser = $connection->requesterID === auth()->id() 
                            ? $connection->receiver 
                            : $connection->requester;
                    @endphp

                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                               <img 
                                    src="{{ $otherUser && $otherUser->userInfo && $otherUser->userInfo->profile_image 
                                        ? asset('storage/' . $otherUser->userInfo->profile_image) 
                                        : asset('img/default-profile.png') }}"
                                    class="rounded-circle border"
                                    style="width:65px;height:65px;object-fit:cover;"
                                    alt="{{ $otherUser?->name ?? 'User' }}"
                                >
                                <div>
                                    <h6 class="fw-semibold mb-1">{{ $otherUser->name }}</h6>
                                    <p class="text-muted mb-1 small">
                                        {{ $otherUser->userInfo->university->name ?? 'University not set' }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <x-view-profile-button :user="$otherUser" />

                                <x-connection-button :connection="$connection" />
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <p>You haven't connected with anyone yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- SENT REQUESTS -->
            <div class="tab-pane fade" id="sent" role="tabpanel">
                @forelse($sent as $connection)
                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img 
                                    src="{{ $connection->receiver && $connection->receiver->userInfo && $connection->receiver->userInfo->profile_image 
                                        ? asset('storage/' . $connection->receiver->userInfo->profile_image) 
                                        : asset('img/default-profile.png') }}"
                                    class="rounded-circle border"
                                    style="width:65px;height:65px;object-fit:cover;"
                                    alt="{{ $connection->receiver?->name ?? 'User' }}"
                                >
                                <div>
                                    <h6 class="fw-semibold mb-1">{{ $connection->receiver->name }}</h6>
                                    <p class="text-muted mb-1 small">
                                        {{ $connection->receiver->userInfo->university->name ?? 'University not set' }}
                                    </p>
                                </div>
                            </div>
                            <x-connection-button :connection="$connection" />
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <p>No sent requests.</p>
                    </div>
                @endforelse
            </div>

            <!-- INCOMING REQUESTS -->
            <div class="tab-pane fade" id="incoming" role="tabpanel">
                @forelse($incoming as $connection)
                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <img 
                                    src="{{ $connection->requester && $connection->requester->userInfo && $connection->requester->userInfo->profile_image 
                                        ? asset('storage/' . $connection->requester->userInfo->profile_image) 
                                        : asset('img/default-profile.png') }}"
                                    class="rounded-circle border"
                                    style="width:65px;height:65px;object-fit:cover;"
                                    alt="{{ $connection->requester?->name ?? 'User' }}"
                                >
                                <div>
                                    <h6 class="fw-semibold mb-1">{{ $connection->requester->name }}</h6>
                                    <p class="text-muted mb-1 small">
                                        {{ $connection->requester->userInfo->university->name ?? 'University not set' }}
                                    </p>
                                </div>
                            </div>
                            
                            <x-connection-button :connection="$connection" />

                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <p>No incoming requests.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<style>
    #connections .nav-pills .nav-link.active {
        background-color: #8c52ff;
        color: #fff;
        border-radius: 50px;
        font-weight: 600;
    }
    #connections .nav-pills .nav-link {
        color: #8c52ff;
        font-weight: 500;
    }
    #connections .card {
        transition: all 0.2s ease-in-out;
    }
    #connections .card:hover {
        background-color: #ffffffff;
        transform: translateY(-2px);
    }
</style>




