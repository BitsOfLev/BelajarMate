<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Login Button -->
        <div class="mt-6">
            <x-primary-button class="w-full py-3 text-center justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Forgot Password | Register -->
        <div class="mt-4 flex justify-center space-x-4 text-sm text-gray-600">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="hover:text-gray-900">
                    {{ __('Forgot password?') }}
                </a>
            @endif
            <span>|</span>
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-800">
                {{ __('Create Account') }}
            </a>
        </div>
    </form>
</x-guest-layout>

