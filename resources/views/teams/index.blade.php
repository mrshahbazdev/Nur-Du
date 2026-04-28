<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Teams') }}</h2>
            <a href="{{ route('teams.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                {{ __('Create Team') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($teams as $team)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ $currentTeam && $currentTeam->id === $team->id ? 'ring-2 ring-indigo-500' : '' }}">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $team->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $team->members_count }} {{ __('Members') }}
                                    </p>
                                </div>
                                @if($currentTeam && $currentTeam->id === $team->id)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ __('Active') }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4 flex items-center space-x-3">
                                <a href="{{ route('teams.show', $team) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ __('Manage') }}
                                </a>
                                @if(!$currentTeam || $currentTeam->id !== $team->id)
                                    <form method="POST" action="{{ route('teams.switch', $team) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-800 font-medium">
                                            {{ __('Switch') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
