@props(['user'])

<button 
    onclick="window.location.href='{{ route('study-partner.social-profile.show', ['user' => $user->id]) }}'" 
    class="bm-btn bm-btn-profile">
        View Profile
</button>