<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal - BelajarMate</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-purple-900 via-indigo-900 to-purple-800 min-h-screen flex items-center justify-center px-4 py-8">

  <div class="max-w-xl w-full">
    <!-- Admin Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 md:p-10 lg:p-12 text-center">
      <!-- Logo -->
      <div class="flex justify-center mb-4 sm:mb-6">
        <img src="{{ asset('img/logo.png') }}" alt="BelajarMate Logo" class="w-20 sm:w-24 md:w-28 h-auto">
      </div>

      <!-- Welcome Header -->
      <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-2">Admin Portal</h1>
      <p class="text-purple-700 font-semibold mb-6 sm:mb-8 text-sm sm:text-base">BelajarMate Management System</p>

      <!-- Warning Box -->
      <div class="bg-amber-50 border-l-4 border-amber-500 p-3 sm:p-4 mb-6 sm:mb-8 text-left rounded-r-lg">
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-xs sm:text-sm font-semibold text-amber-800">Restricted Access</h3>
            <p class="text-xs sm:text-sm text-amber-700 mt-1">
              This portal is exclusively for authorized administrators. Unauthorized access attempts are monitored and logged.
            </p>
          </div>
        </div>
      </div>

      <!-- Welcome Message -->
      <div class="mb-6 sm:mb-8 text-gray-600">
        <p class="mb-3 sm:mb-4 text-sm sm:text-base">Welcome back, Administrator.</p>
        <p class="text-xs sm:text-sm">Please authenticate to access the management dashboard.</p>
      </div>

      <!-- Login Button -->
      <a href="{{ route('admin.login') }}" class="block w-full bg-purple-600 text-white px-6 py-3 sm:py-3.5 rounded-full font-semibold hover:bg-purple-700 transition mb-3 sm:mb-4 text-sm sm:text-base">
        Admin Login
      </a>
    </div>

    <!-- Footer Note -->
    <p class="text-purple-200 text-xs sm:text-sm text-center mt-4 sm:mt-6">
      © {{ date('Y') }} BelajarMate. Admin Portal v1.0
    </p>
  </div>

</body>
</html>