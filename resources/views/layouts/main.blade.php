<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Default Title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!--======= CSS ======= -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/pomodoro.css') }}"> -->
    <!--======= Boxicons CSS ======= -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="page-wrapper">
        <!-- Sidebar (full height on left) -->
        @include('includes.sidebar')
        
        <!-- Right side content -->
        <div class="right-content">
            <!-- Topbar -->
            @include('includes.topbar')
            
            <!-- Main content -->
            <main class="main-content">
                @yield('content')
            </main>
            
            <!-- @if (Route::currentRouteName() === 'home')
                <footer class="footer">
                    @include('includes.footer')
                </footer>
            @endif -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/script.js') }}"></script>
    <!-- <script src="{{ asset('js/pomodoro.js') }}"></script> -->
    <!-- Blog Like Script -->
    <!-- <script src="{{ asset('js/blog-like.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>