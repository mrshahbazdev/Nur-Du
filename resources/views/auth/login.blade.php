<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('Sign in to your account') }}</h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('Sign up') }}</a>
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
        </div>

        <x-primary-button class="w-full justify-center py-2.5">
            {{ __('Log in') }}
        </x-primary-button>
    </form>
</x-guest-layout>
