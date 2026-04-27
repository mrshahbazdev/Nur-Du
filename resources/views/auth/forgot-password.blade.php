<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('Reset Password') }}</h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-2.5">
            {{ __('Email Password Reset Link') }}
        </x-primary-button>

        <p class="text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">&larr; {{ __('Back') }}</a>
        </p>
    </form>
</x-guest-layout>
