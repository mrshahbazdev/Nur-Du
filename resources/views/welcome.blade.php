<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nur-Du &mdash; Vision Alignment Tool</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
            {{-- Navbar --}}
            <nav class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
                <span class="text-2xl font-bold text-indigo-600">Nur-Du</span>
                <div class="space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Get Started</a>
                    @endauth
                </div>
            </nav>

            {{-- Hero --}}
            <div class="max-w-4xl mx-auto px-6 pt-20 pb-16 text-center">
                <h1 class="text-5xl font-bold text-gray-900 leading-tight">
                    Keep your <span class="text-indigo-600">vision</span> alive.
                </h1>
                <p class="mt-6 text-xl text-gray-600 max-w-2xl mx-auto">
                    A simple tool that ensures every decision, priority, and action stays aligned with where your company wants to go long-term.
                </p>
                <div class="mt-10 flex items-center justify-center space-x-4">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-700 transition">
                            Start Free
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Log In
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-700 transition">
                            Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>

            {{-- Features --}}
            <div class="max-w-6xl mx-auto px-6 py-20">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Vision Statement</h3>
                        <p class="text-sm text-gray-600">One clear vision with 3&ndash;5 guiding principles everyone can understand.</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Quarterly Focus</h3>
                        <p class="text-sm text-gray-600">1&ndash;3 strategic priorities per quarter with clear owners and KPIs.</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Decision Filter</h3>
                        <p class="text-sm text-gray-600">Traffic light system for every major decision. Red must be justified.</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Monthly Check</h3>
                        <p class="text-sm text-gray-600">3 fixed reflection questions. Notes and action items. 15 minutes.</p>
                    </div>
                </div>
            </div>

            {{-- Value Props --}}
            <div class="max-w-4xl mx-auto px-6 py-16 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Why Nur-Du?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div class="flex items-start space-x-3">
                        <span class="text-green-500 mt-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium text-gray-900">Keeps strategy alive</p>
                            <p class="text-sm text-gray-500">Regular rhythm beats one-time planning sessions.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-green-500 mt-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium text-gray-900">Reduces misaligned decisions</p>
                            <p class="text-sm text-gray-500">Every decision gets a vision alignment check.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-green-500 mt-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium text-gray-900">Minimal time investment</p>
                            <p class="text-sm text-gray-500">15 min monthly check + 30&ndash;60 min quarterly review.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-green-500 mt-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-medium text-gray-900">No OKR circus needed</p>
                            <p class="text-sm text-gray-500">Lightweight priorities with clear ownership.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <footer class="max-w-7xl mx-auto px-6 py-8 text-center text-sm text-gray-400 border-t border-gray-200">
                Nur-Du &mdash; Vision Alignment Tool &copy; {{ date('Y') }}
            </footer>
        </div>
    </body>
</html>
