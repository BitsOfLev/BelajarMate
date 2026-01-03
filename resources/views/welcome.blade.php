<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BelajarMate</title>
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(to bottom right, #e0e7ff, #d8b4fe, #fbcfe8);">

  <!-- Top Navbar -->
  <nav class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <img src="{{ asset('img/logo.png') }}" alt="BelajarMate Logo" class="w-16 h-auto">
        <span class="text-xl font-bold text-gray-900">BelajarMate</span>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('login') }}" class="text-purple-700 px-5 py-2 rounded-full font-medium hover:bg-purple-50 transition">
          Login
        </a>
        <a href="{{ route('register') }}" class="bg-purple-600 text-white px-5 py-2 rounded-full font-medium hover:bg-purple-700 transition">
          Register
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Section -->
  <section class="min-h-screen flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        
        <!-- Left Side -->
        <div class="space-y-8">
          <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
            Study together,<br/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-purple-400">achieve more</span>
          </h1>
          
          <p class="text-lg text-gray-700 max-w-md leading-relaxed">
            BelajarMate is your digital <span class="font-semibold">belajar mate</span>, combining personal study support with meaningful collaboration.
            <br class="hidden sm:block"></br>
            Connect with students from all universities, plan study sessions, and stay motivated while learning together.
          </p>
                    
          <div class="flex gap-4 pt-4">
            <a href="{{ route('login') }}" class="bg-white border-2 border-purple-600 text-purple-600 px-8 py-3 rounded-full font-medium hover:bg-purple-50 transition shadow-md">
              Login
            </a>
            <a href="{{ route('register') }}" class="bg-purple-600 text-white px-8 py-3 rounded-full font-medium hover:bg-purple-700 transition shadow-lg">
              Register
            </a>
          </div>
        </div>

        <!-- Right Side -->
        <div class="space-y-8">
          <div class="bg-white rounded-2xl shadow-xl border border-purple-100 overflow-hidden">
            <img src="{{ asset('img/belajarmate-poster.png') }}" alt="BelajarMate Dashboard" class="w-full h-auto">
          </div>
          
          <div class="space-y-6">
            <div class="flex gap-4">
              <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user-friends text-purple-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900 mb-1">Find Study Partners</h3>
                <p class="text-sm text-gray-600">Match with students based on courses and study preferences</p>
              </div>
            </div>

            <div class="flex gap-4">
              <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-check text-purple-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900 mb-1">Manage Sessions</h3>
                <p class="text-sm text-gray-600">Plan study sessions with your study partners</p>
              </div>
            </div>

            <div class="flex gap-4">
              <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-book-open text-purple-600"></i>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900 mb-1">Share Resources</h3>
                <p class="text-sm text-gray-600">Organize notes and connect through blogs and study tips</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-20 bg-white/60 backdrop-blur-sm">
    <div class="max-w-6xl mx-auto px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-3">Features</h2>
        <p class="text-gray-600">Everything you need in one place</p>
      </div>

      <div class="space-y-24">
        
        <!-- Feature 1: Study Partner Matching -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="space-y-4">
            <div class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-sm font-medium">
              <i class="fas fa-users"></i>
              <span>Partner Matching</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Find compatible study partners</h3>
            <p class="text-gray-600 leading-relaxed">
              Connect with students who share similar courses and learning styles. BelajarMate uses basic profile information, such as course and MBTI personality type, to suggest potential study partners.
            </p>
          </div>
          <div class="bg-white rounded-2xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Image placeholder -->
            <div class="aspect-video bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center">
              <img src="{{ asset('img/study-partner.png') }}" alt="Study-Partner" class="w-full h-auto">
            </div>
          </div>
        </div>

        <!-- Feature 2: Study Session -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="bg-white rounded-2xl shadow-lg border border-purple-100 overflow-hidden md:order-first order-last">
            <!-- Image placeholder -->
            <div class="aspect-video bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
              <img src="{{ asset('img/study session.png') }}" alt="Study-Planner" class="w-full h-auto">
            </div>
          </div>
          <div class="space-y-4">
            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium">
              <i class="fas fa-chalkboard-teacher"></i>
              <span>Study Session</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Create and join study sessions</h3>
            <p class="text-gray-600 leading-relaxed">
              Organize group study sessions and invite partners. Set session goals, topics, and duration to stay focused and productive together.
            </p>
          </div>
        </div>

        <!-- Feature 3: Study Planner -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="space-y-4">
            <div class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-medium">
              <i class="fas fa-calendar-alt"></i>
              <span>Study Planner</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Plan your study schedule</h3>
            <p class="text-gray-600 leading-relaxed">
              Schedule your study time effectively with our planner. Set goals, create study plans for each subject, and track your progress over time to build consistent study habits.
            </p>
          </div>
          <div class="bg-white rounded-2xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Image placeholder -->
            <div class="aspect-video bg-gradient-to-br from-indigo-100 to-indigo-50 flex items-center justify-center">
              <img src="{{ asset('img/study planner.png') }}" alt="Study-Planner" class="w-full h-auto">
            </div>
          </div>
        </div>

        <!-- Feature 4: Blog -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="bg-white rounded-2xl shadow-lg border border-purple-100 overflow-hidden md:order-first order-last">
            <!-- Image placeholder -->
            <div class="aspect-video bg-gradient-to-br from-pink-100 to-pink-50 flex items-center justify-center">
              <img src="{{ asset('img/blog.png') }}" alt="Study-Planner" class="w-full h-auto">
            </div>
          </div>
          <div class="space-y-4">
            <div class="inline-flex items-center gap-2 bg-pink-100 text-pink-700 px-4 py-2 rounded-full text-sm font-medium">
              <i class="fas fa-pen-fancy"></i>
              <span>Blog</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Share knowledge and tips</h3>
            <p class="text-gray-600 leading-relaxed">
              Write and read study guides, tips, and insights from fellow students. Share your learning experiences, exam strategies, and motivational stories with the community.
            </p>
          </div>
        </div>

        <!-- Feature 5: Pomodoro Timer -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="space-y-4">
            <div class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium">
              <i class="fas fa-clock"></i>
              <span>Pomodoro Timer</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Stay focused with Pomodoro</h3>
            <p class="text-gray-600 leading-relaxed">
              Use the built-in Pomodoro timer to maintain focus during study sessions. Work in 25-minute intervals with short breaks to maximize productivity and prevent burnout.
            </p>
          </div>
          <div class="bg-white rounded-2xl shadow-lg border border-purple-100 overflow-hidden">
            <!-- Image placeholder -->
            <div class="aspect-video bg-gradient-to-br from-red-100 to-red-50 flex items-center justify-center">
              <img src="{{ asset('img/pomodoro.png') }}" alt="Study-Partner" class="w-full h-auto">
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-8 bg-white border-t border-purple-100">
    <div class="max-w-7xl mx-auto px-8 text-center text-sm text-gray-700">
      <p>© {{ date('Y') }} BelajarMate</p>
    </div>
  </footer>

</body>
</html>





