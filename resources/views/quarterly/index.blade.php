<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quarterly Focus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Create / Select Quarter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Create or Update Quarter</h3>
                    <form method="POST" action="{{ route('quarterly.store') }}" class="flex flex-wrap items-end gap-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quarter</label>
                            <select name="quarter" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach(['Q1','Q2','Q3','Q4'] as $q)
                                    <option value="{{ $q }}" {{ $q === $currentQuarter ? 'selected' : '' }}>{{ $q }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                            <select name="year" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                            <input type="text" name="notes" placeholder="Quarterly theme or focus area"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <x-primary-button>Save Quarter</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- Quarter List --}}
            @if($focuses->count())
                <div class="space-y-4">
                    @foreach($focuses as $focus)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $focus->quarter }} {{ $focus->year }}
                                            @if($focus->quarter === $currentQuarter && $focus->year == $currentYear)
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">Current</span>
                                            @endif
                                        </h3>
                                        @if($focus->notes)
                                            <p class="text-sm text-gray-500 mt-1">{{ $focus->notes }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('quarterly.show', $focus) }}" class="text-sm text-indigo-600 hover:text-indigo-800">Manage &rarr;</a>
                                        <form method="POST" action="{{ route('quarterly.destroy', $focus) }}" onsubmit="return confirm('Delete this quarter and all its priorities?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                @if($focus->strategicPriorities->count())
                                    <div class="space-y-2">
                                        @foreach($focus->strategicPriorities as $priority)
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                                <div>
                                                    <span class="font-medium text-gray-800">{{ $priority->title }}</span>
                                                    @if($priority->kpi)
                                                        <span class="text-sm text-gray-500 ml-2">KPI: {{ $priority->kpi }}</span>
                                                    @endif
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $priority->status === 'on_track' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $priority->status === 'at_risk' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $priority->status === 'off_track' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ str_replace('_', ' ', ucfirst($priority->status)) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No priorities yet. <a href="{{ route('quarterly.show', $focus) }}" class="text-indigo-600 underline">Add some</a>.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        No quarterly focuses created yet. Use the form above to get started.
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
