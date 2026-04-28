<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
                        North-Star
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('vision.index')" :active="request()->routeIs('vision.*')">
                        {{ __('Vision') }}
                    </x-nav-link>
                    <x-nav-link :href="route('quarterly.index')" :active="request()->routeIs('quarterly.*')">
                        {{ __('Quarterly Focus') }}
                    </x-nav-link>
                    <x-nav-link :href="route('decisions.index')" :active="request()->routeIs('decisions.*')">
                        {{ __('Decisions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('checks.index')" :active="request()->routeIs('checks.*')">
                        {{ __('Vision Checks') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:space-x-4">
                {{-- Team Switcher --}}
                @php $currentTeam = Auth::user()->currentTeam; @endphp
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-md text-gray-600 bg-gray-50 hover:bg-gray-100 hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                            <svg class="w-4 h-4 me-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="max-w-[120px] truncate">{{ $currentTeam?->name ?? __('No Team') }}</span>
                            <svg class="ms-1 fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider">{{ __('Switch Team') }}</div>
                        @foreach(Auth::user()->teams as $team)
                            <form method="POST" action="{{ route('teams.switch', $team) }}">
                                @csrf
                                <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="{{ $currentTeam && $currentTeam->id === $team->id ? 'bg-indigo-50 text-indigo-700' : '' }}">
                                    {{ $team->name }}
                                    @if($currentTeam && $currentTeam->id === $team->id)
                                        <svg class="inline w-4 h-4 ms-1 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    @endif
                                </x-dropdown-link>
                            </form>
                        @endforeach
                        <div class="border-t border-gray-100"></div>
                        <x-dropdown-link :href="route('teams.index')">{{ __('Manage Teams') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('teams.create')">{{ __('Create Team') }}</x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <x-language-switcher />

                {{-- User Menu --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('vision.index')" :active="request()->routeIs('vision.*')">
                {{ __('Vision') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('quarterly.index')" :active="request()->routeIs('quarterly.*')">
                {{ __('Quarterly Focus') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('decisions.index')" :active="request()->routeIs('decisions.*')">
                {{ __('Decisions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('checks.index')" :active="request()->routeIs('checks.*')">
                {{ __('Vision Checks') }}
            </x-responsive-nav-link>
        </div>

        {{-- Mobile Team Switcher --}}
        <div class="pt-3 pb-2 border-t border-gray-200">
            <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider">{{ __('Team') }}</div>
            @foreach(Auth::user()->teams as $team)
                <form method="POST" action="{{ route('teams.switch', $team) }}">
                    @csrf
                    <x-responsive-nav-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ $team->name }}
                        @if($currentTeam && $currentTeam->id === $team->id)
                            <span class="text-indigo-600 font-semibold">•</span>
                        @endif
                    </x-responsive-nav-link>
                </form>
            @endforeach
            <x-responsive-nav-link :href="route('teams.index')">{{ __('Manage Teams') }}</x-responsive-nav-link>
        </div>

        <div class="px-4 py-2 border-t border-gray-200">
            <x-language-switcher />
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
