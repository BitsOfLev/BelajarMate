<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Buttons -->
        <div class="flex flex-col items-center mt-6 gap-4">
            <x-primary-button class="w-full sm:w-full py-3 justify-center text-center">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>

            <a href="{{ route('login') }}" class="w-full sm:w-full py-3 text-center bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</x-guest-layout>

