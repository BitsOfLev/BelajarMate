<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Dashboard' }} | BelajarMate Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#9333EA',
                        secondary: '#A855F7'
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">

    <!-- Include Sidebar Component -->
    @include('admin.components.sidebar')

    <!-- Main content -->
    <main class="min-h-screen">
        <!-- Include Topbar Component -->
        @include('admin.components.topbar', [
            'pageTitle' => $pageTitle ?? 'Dashboard',
            'pageSubtitle' => $pageSubtitle ?? 'Welcome back, Admin',
            'showBanner' => $showBanner ?? true,
            'bannerMessage' => $bannerMessage ?? 'Manage users, moderate content, handle reports, and maintain system data.'
        ])

        <!-- Page Content -->
        <div class="p-4 lg:p-6 max-w-[1600px] mx-auto">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('scripts')
</body>
</html>

