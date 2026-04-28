<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'North-Star') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            {{-- Left: Branding Panel --}}
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-300 rounded-full blur-3xl"></div>
                </div>
                <div class="relative z-10 flex flex-col justify-center px-16 text-white">
                    <a href="/" class="text-3xl font-bold mb-8">North-Star</a>
                    <h2 class="text-4xl font-bold leading-tight mb-6">{{ __('Keep your vision alive.') }}</h2>
                    <p class="text-lg text-indigo-200 mb-12 leading-relaxed">
                        {{ __('A simple tool that ensures every decision, priority, and action stays aligned with where your company wants to go long-term.') }}
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <span class="text-indigo-100">{{ __('Vision Statement') }} & {{ __('Guiding Principles') }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-indigo-100">{{ __('Quarterly Focus') }} & {{ __('Strategic Priorities') }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span class="text-indigo-100">{{ __('Decision Filter') }} & {{ __('Vision Checks') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Form Panel --}}
            <div class="w-full lg:w-1/2 flex flex-col">
                {{-- Top bar with language switcher --}}
                <div class="flex items-center justify-between px-8 pt-6">
                    <a href="/" class="lg:hidden text-2xl font-bold text-indigo-600">North-Star</a>
                    <div class="ml-auto">
                        <x-language-switcher />
                    </div>
                </div>

                {{-- Form content --}}
                <div class="flex-1 flex items-center justify-center px-8 py-12">
                    <div class="w-full max-w-md">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
