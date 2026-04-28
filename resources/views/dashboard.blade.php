<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Vision Statement Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Vision Statement') }}</h3>
                        <a href="{{ route('vision.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">{{ __('Manage') }} &rarr;</a>
                    </div>
                    @if($vision)
                        <blockquote class="border-l-4 border-indigo-500 pl-4 italic text-gray-700 text-lg">
                            &ldquo;{{ $vision->statement }}&rdquo;
                        </blockquote>
                        @if($vision->guidingPrinciples->count())
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500 mb-2">{{ __('Guiding Principles') }}:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($vision->guidingPrinciples as $p)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            {{ $p->title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500">{{ __('No vision defined yet.') }} <a href="{{ route('vision.index') }}" class="text-indigo-600 underline">{{ __('Create one') }}</a>.</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Current Quarter --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $currentQuarter }} {{ $currentYear }} {{ __('Focus') }}</h3>
                            <a href="{{ route('quarterly.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">{{ __('All Quarters') }} &rarr;</a>
                        </div>
                        @if($quarterlyFocus && $quarterlyFocus->strategicPriorities->count())
                            <div class="space-y-3">
                                @foreach($quarterlyFocus->strategicPriorities as $priority)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $priority->title }}</p>
                                            @if($priority->owner)
                                                <p class="text-sm text-gray-500">{{ __('Owner') }}: {{ $priority->owner }}</p>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $priority->status === 'on_track' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $priority->status === 'at_risk' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $priority->status === 'off_track' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $priority->status === 'on_track' ? __('On Track') : ($priority->status === 'at_risk' ? __('At Risk') : __('Off Track')) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">{{ __('No priorities set for this quarter.') }} <a href="{{ route('quarterly.index') }}" class="text-indigo-600 underline">{{ __('Set them now') }}</a>.</p>
                        @endif
                    </div>
                </div>

                {{-- Decision Alignment Stats --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Decision Alignment') }}</h3>
                            <a href="{{ route('decisions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">{{ __('Decisions') }} &rarr;</a>
                        </div>
                        @php $total = $decisionStats['green'] + $decisionStats['yellow'] + $decisionStats['red']; @endphp
                        @if($total > 0)
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex-1 text-center">
                                    <div class="text-3xl font-bold text-green-600">{{ $decisionStats['green'] }}</div>
                                    <div class="text-sm text-gray-500">{{ __('Aligned') }}</div>
                                </div>
                                <div class="flex-1 text-center">
                                    <div class="text-3xl font-bold text-yellow-500">{{ $decisionStats['yellow'] }}</div>
                                    <div class="text-sm text-gray-500">{{ __('Neutral') }}</div>
                                </div>
                                <div class="flex-1 text-center">
                                    <div class="text-3xl font-bold text-red-600">{{ $decisionStats['red'] }}</div>
                                    <div class="text-sm text-gray-500">{{ __('Misaligned') }}</div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 flex overflow-hidden">
                                <div class="bg-green-500 h-3" style="width: {{ ($decisionStats['green'] / $total) * 100 }}%"></div>
                                <div class="bg-yellow-400 h-3" style="width: {{ ($decisionStats['yellow'] / $total) * 100 }}%"></div>
                                <div class="bg-red-500 h-3" style="width: {{ ($decisionStats['red'] / $total) * 100 }}%"></div>
                            </div>
                        @else
                            <p class="text-gray-500">{{ __('No decisions logged yet.') }} <a href="{{ route('decisions.create') }}" class="text-indigo-600 underline">{{ __('Log one') }}</a>.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Recent Decisions --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Recent Decisions') }}</h3>
                        @if($recentDecisions->count())
                            <div class="space-y-2">
                                @foreach($recentDecisions as $decision)
                                    <div class="flex items-center space-x-3 p-2 rounded hover:bg-gray-50">
                                        <span class="flex-shrink-0 w-3 h-3 rounded-full
                                            {{ $decision->alignment === 'green' ? 'bg-green-500' : '' }}
                                            {{ $decision->alignment === 'yellow' ? 'bg-yellow-400' : '' }}
                                            {{ $decision->alignment === 'red' ? 'bg-red-500' : '' }}">
                                        </span>
                                        <span class="text-gray-900">{{ $decision->title }}</span>
                                        <span class="text-xs text-gray-400 ml-auto">{{ $decision->created_at->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">{{ __('No decisions yet.') }}</p>
                        @endif
                    </div>
                </div>

                {{-- Latest Vision Check --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Latest Vision Check') }}</h3>
                            <a href="{{ route('checks.create') }}" class="text-sm text-indigo-600 hover:text-indigo-800">{{ __('New Check') }} &rarr;</a>
                        </div>
                        @if($latestCheck)
                            <p class="text-sm text-gray-500 mb-3">{{ $latestCheck->check_date->format('M d, Y') }}</p>
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-700">{{ __('Paying into vision?') }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        {{ $latestCheck->q1_answer === 'yes' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $latestCheck->q1_answer === 'partially' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $latestCheck->q1_answer === 'no' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ $latestCheck->q1_answer === 'yes' ? __('Yes') : ($latestCheck->q1_answer === 'partially' ? __('Partially') : __('No')) }}
                                    </span>
                                </div>
                                @if($latestCheck->actionItems->count())
                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-500">{{ __('Action Items') }}:</p>
                                        @foreach($latestCheck->actionItems as $item)
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="{{ $item->completed ? 'line-through text-gray-400' : 'text-gray-700' }} text-sm">{{ $item->title }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500">{{ __('No vision checks yet.') }} <a href="{{ route('checks.create') }}" class="text-indigo-600 underline">{{ __('Start one') }}</a>.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
