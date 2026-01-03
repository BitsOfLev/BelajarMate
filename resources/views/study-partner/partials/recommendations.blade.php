<!-- ========================== -->
<!-- RECOMMENDED PARTNERS TAB -->
<!-- ========================== -->
<div class="tab-pane fade show active" id="recommended" role="tabpanel">
    <div class="card p-4 shadow-sm mb-4 border-0 rounded-4">

        @if($profileIncomplete ?? false)
            <div class="text-center text-muted py-5">
                <p>Please complete your profile to get recommendations.</p>
                <a href="{{ route('profile.info.edit') }}" 
                   class="btn btn-sm rounded-pill text-white px-4" 
                   style="background-color: #8c52ff;">
                    Complete My Profile
                </a>
            </div> 
        @else
            <!-- FILTER BAR -->
            <div class="d-flex align-items-center gap-2 mb-4 px-3 py-2 bg-white border rounded-3 shadow-sm">
                <span class="text-muted small fw-semibold">Filter:</span>
                <select class="form-select form-select-sm border-1 shadow-none bg-light rounded-pill px-3 py-1" 
                        style="width: auto; font-size: 0.85rem;" id="filterDropdown" onchange="applyFilter()">
                    <option value="">Select Filter</option>
                    <option value="same_uni" {{ request('filter') == 'same_uni' ? 'selected' : '' }}>Same University</option>
                    <option value="same_course" {{ request('filter') == 'same_course' ? 'selected' : '' }}>Same Course</option>
                    <option value="male" {{ request('filter') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('filter') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="education_level" {{ request('filter') == 'education_level' ? 'selected' : '' }}>Same Education Level</option>
                    <option value="active_7_days" {{ request('filter') == 'active_7_days' ? 'selected' : '' }}>Active within 7 Days</option>
                </select>
            </div>


            <!-- RECOMMENDATION LIST -->
            <div class="list-group list-group-flush">
                @if(isset($recommendation) && count($recommendation) > 0)
                    @foreach($recommendation as $rec)
                        @php
                            $user = $rec->recommendedUser;
                            $info = $user->userInfo;
                            $score = round($rec->score);
                            $scoreColor = '#8c52ff';
                            $factors = !empty($rec->factors) ? explode(',', $rec->factors) : [];
                        @endphp

                        <div class="d-flex flex-column flex-lg-row align-items-stretch mb-3" style="gap: 15px;">
                            <!-- USER CARD -->
                            <div class="flex-grow-1 p-3 rounded-4 shadow-sm border-0 bg-white d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                                <!-- USER INFO -->
                                <div class="d-flex align-items-start flex-sm-row flex-column w-100" style="gap: 15px;">
                                    <a href='{{ route('study-partner.social-profile.show', ['user' => $user->id]) }}' title="View Profile">
                                        <img 
                                            src="{{ $info->profile_image ? asset('storage/' . $info->profile_image) : asset('img/default-profile.png')}}"
                                            class="rounded-circle border flex-shrink-0"
                                            style="width:70px;height:70px;object-fit:cover;"
                                        >
                                    </a>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-semibold mb-1">{{ $user->name }}</h6>
                                        <div class="text-muted small lh-sm">
                                            <p class="mb-1"><strong>University:</strong> {{ $info->university->name ?? 'Not specified' }}</p>
                                            <p class="mb-1"><strong>Course:</strong> {{ $info->course->name ?? 'Not specified' }}</p>
                                            <p class="mb-1"><strong>Education Level:</strong> {{ $info->educationLevel->name ?? 'Not specified' }}</p>
                                            <p class="mb-0"><strong>Year:</strong> {{ $info->academicYear ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="d-flex flex-row flex-sm-column gap-2 mt-3 mt-sm-0 ms-sm-3 
                                    justify-content-center justify-content-sm-end align-items-center align-items-sm-end 
                                    w-100 w-sm-auto">

                                    <x-view-profile-button :user="$user" />

                                    <x-connection-button :user="$user" />

                                </div>
                            </div>

                            <!-- SCORE CARD -->
                            <div class="rounded-4 shadow-sm border-0 d-flex flex-column align-items-center justify-content-center position-relative"
                                 style="min-width:150px; background-color:white; border:2px solid {{ $scoreColor }}; padding:15px;">
                                <h5 class="fw-bold mb-1" style="color:{{ $scoreColor }};">{{ $score }}%</h5>
                                <small class="text-muted mb-2">Match</small>

                                @if(count($factors))
                                    <a href="javascript:void(0)" 
                                       class="text-decoration-none small fw-semibold" 
                                       style="color:{{ $scoreColor }};"
                                       onclick="toggleFactors('{{ $user->id }}')"
                                       title="View Match Factor">
                                        See why
                                    </a>

                                    <!-- FACTORS POPUP -->
                                    <div id="factors-{{ $user->id }}" 
                                         class="factors-popup d-none"
                                         style="position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:1050;">
                                        <div class="bg-white rounded-4 shadow-lg p-4 position-absolute top-50 start-50 translate-middle" 
                                             style="width:90%; max-width:400px; border:2px solid {{ $scoreColor }};">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <strong style="color:{{ $scoreColor }};">Match Factors</strong>
                                                <button class="btn btn-sm btn-link text-muted p-0 fs-4 lh-1" 
                                                        onclick="toggleFactors('{{ $user->id }}')">&times;</button>
                                            </div>
                                            <ul class="small text-muted mb-0 ps-3">
                                                @foreach($factors as $factor)
                                                    <li>{{ trim($factor) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-5">
                        <p>No recommendations available yet.</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- JS -->
<script>
    //factor pop-up
    function toggleFactors(userId) {
        const popup = document.getElementById('factors-' + userId);
        popup.classList.toggle('d-none');
    }

    //filtering
    function applyFilter() {
        const filter = document.getElementById('filterDropdown').value;
        let url = new URL(window.location.href);
        
        if(filter) {
            url.searchParams.set('filter', filter);
        } else {
            url.searchParams.delete('filter');
        }

        window.location.href = url.toString();
    }
</script>





