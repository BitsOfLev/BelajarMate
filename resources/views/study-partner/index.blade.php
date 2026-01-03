@extends('layouts.main')

@section('title', 'Study Partner')

@section('content')

<div class="container my-5 study-partner-page">
    <div class="mx-auto" style="max-width: 1080px;">
        <h3 class="page-title">Study Partner</h3>

        <!-- INTRODUCTION / PURPOSE SECTION -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: #ffffffff;">
            <div class="card-body p-4 text-center">
                <h5 class="fw-semibold mb-3" style="color: #5a2ca0;">Find your perfect study partner 🎯</h5>
                <p class="text-muted mb-3" style="font-size: 0.95rem;">
                    This page helps you connect with other university students who share similar study interests and availability.
                    To get the best recommendations, make sure your study preferences and academic details are filled in!
                </p>
                <a href="{{ route('profile.info.edit') }}" class="btn btn-sm rounded-pill text-white px-4" 
                   style="background-color: #8c52ff;">
                    Complete My Profile
                </a>
            </div>
        </div>

        <!-- MAIN TABS -->
        <ul class="nav nav-tabs mb-4" id="partnerTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="recommended-tab" data-bs-toggle="tab" data-bs-target="#recommended" type="button" role="tab">
                    Recommended Partners
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="connections-tab" data-bs-toggle="tab" data-bs-target="#connections" type="button" role="tab">
                    Connections
                </button>
            </li>
        </ul>

        <div class="tab-content" id="partnerTabContent">
            @include('study-partner.partials.recommendations')
            @include('study-partner.partials.connections')
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        transition: 0.2s ease-in-out;
    }

    .study-partner-page .nav-tabs .nav-link.active {
        background-color: #8c52ff;
        color: #fff;
        border: none;
        border-radius: 8px 8px 0 0;
    }

    .study-partner-page .nav-tabs .nav-link {
        color: #6f42c1;
    }

    .list-group-item {
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f0ebff;
    }
</style>
@endsection


