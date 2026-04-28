<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $quarterlyFocus->quarter }} {{ $quarterlyFocus->year }} &mdash; {{ __('Strategic Priorities') }}
            </h2>
            <a href="{{ route('quarterly.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">&larr; {{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($quarterlyFocus->notes)
                <div class="bg-indigo-50 border border-indigo-200 text-indigo-700 px-4 py-3 rounded">
                    {{ $quarterlyFocus->notes }}
                </div>
            @endif

            {{-- Existing Priorities --}}
            @if($quarterlyFocus->strategicPriorities->count())
                <div class="space-y-4">
                    @foreach($quarterlyFocus->strategicPriorities as $priority)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ editing: false }">
                            <div class="p-6">
                                <div x-show="!editing">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <h4 class="text-lg font-medium text-gray-900">{{ $priority->title }}</h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $priority->status === 'on_track' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $priority->status === 'at_risk' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $priority->status === 'off_track' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $priority->status === 'on_track' ? __('On Track') : ($priority->status === 'at_risk' ? __('At Risk') : __('Off Track')) }}
                                                </span>
                                            </div>
                                            <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-500">
                                                @if($priority->owner)
                                                    <span>{{ __('Owner') }}: <strong>{{ $priority->owner }}</strong></span>
                                                @endif
                                                @if($priority->kpi)
                                                    <span>KPI: <strong>{{ $priority->kpi }}</strong></span>
                                                @endif
                                            </div>
                                            @if($priority->notes)
                                                <p class="mt-2 text-sm text-gray-600">{{ $priority->notes }}</p>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2 ml-4">
                                            <button @click="editing = true" class="text-sm text-indigo-600 hover:text-indigo-800">{{ __('Edit') }}</button>
                                            <form method="POST" action="{{ route('priorities.destroy', $priority) }}" onsubmit="return confirm('Remove this priority?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">{{ __('Delete') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="editing" x-cloak>
                                    <form method="POST" action="{{ route('priorities.update', $priority) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Priority Title') }}</label>
                                                <input type="text" name="title" value="{{ $priority->title }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Owner') }}</label>
                                                <input type="text" name="owner" value="{{ $priority->owner }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">KPI</label>
                                                <input type="text" name="kpi" value="{{ $priority->kpi }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                                                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <option value="on_track" {{ $priority->status === 'on_track' ? 'selected' : '' }}>{{ __('On Track') }}</option>
                                                    <option value="at_risk" {{ $priority->status === 'at_risk' ? 'selected' : '' }}>{{ __('At Risk') }}</option>
                                                    <option value="off_track" {{ $priority->status === 'off_track' ? 'selected' : '' }}>{{ __('Off Track') }}</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Notes') }}</label>
                                                <textarea name="notes" rows="2"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $priority->notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex space-x-2">
                                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                                            <button type="button" @click="editing = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">{{ __('Cancel') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Add Priority (max 3) --}}
            @if($quarterlyFocus->strategicPriorities->count() < 3)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Add Strategic Priority') }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ __('Define 1-3 strategic priorities that clearly contribute to your vision.') }}</p>
                        <form method="POST" action="{{ route('quarterly.priorities.store', $quarterlyFocus) }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Priority Title') }}</label>
                                    <input type="text" name="title" placeholder="e.g. Simplify customer experience"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Owner') }}</label>
                                    <input type="text" name="owner" placeholder="Responsible person"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('KPI') }}</label>
                                    <input type="text" name="kpi" placeholder="e.g. Lead time down 20%"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-primary-button>{{ __('Add Priority') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded">
                    {{ __('Maximum of 3 strategic priorities reached for this quarter.') }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
