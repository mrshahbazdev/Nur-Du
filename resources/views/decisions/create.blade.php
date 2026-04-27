<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Log Decision') }}
            </h2>
            <a href="{{ route('decisions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">&larr; {{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('decisions.store') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Decision Title') }}</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }} (optional)</label>
                                <textarea name="description" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Vision Alignment') }}</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none
                                        {{ old('alignment') === 'green' ? 'border-green-500 ring-2 ring-green-500' : 'border-gray-300' }}">
                                        <input type="radio" name="alignment" value="green" class="sr-only" {{ old('alignment') === 'green' ? 'checked' : '' }} required>
                                        <span class="flex flex-1 flex-col text-center">
                                            <span class="block w-8 h-8 rounded-full bg-green-500 mx-auto mb-2"></span>
                                            <span class="text-sm font-medium text-gray-900">{{ __('Strengthens') }}</span>
                                            <span class="text-xs text-gray-500">{{ __('Aligned') }}</span>
                                        </span>
                                    </label>
                                    <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none
                                        {{ old('alignment') === 'yellow' ? 'border-yellow-500 ring-2 ring-yellow-500' : 'border-gray-300' }}">
                                        <input type="radio" name="alignment" value="yellow" class="sr-only" {{ old('alignment') === 'yellow' ? 'checked' : '' }}>
                                        <span class="flex flex-1 flex-col text-center">
                                            <span class="block w-8 h-8 rounded-full bg-yellow-400 mx-auto mb-2"></span>
                                            <span class="text-sm font-medium text-gray-900">{{ __('Neutral') }}</span>
                                            <span class="text-xs text-gray-500">{{ __('No clear impact') }}</span>
                                        </span>
                                    </label>
                                    <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none
                                        {{ old('alignment') === 'red' ? 'border-red-500 ring-2 ring-red-500' : 'border-gray-300' }}">
                                        <input type="radio" name="alignment" value="red" class="sr-only" {{ old('alignment') === 'red' ? 'checked' : '' }}>
                                        <span class="flex flex-1 flex-col text-center">
                                            <span class="block w-8 h-8 rounded-full bg-red-500 mx-auto mb-2"></span>
                                            <span class="text-sm font-medium text-gray-900">{{ __('Weakens') }}</span>
                                            <span class="text-xs text-gray-500">{{ __('Misaligned') }}</span>
                                        </span>
                                    </label>
                                </div>
                                @error('alignment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Justification') }}</label>
                                <p class="text-xs text-gray-500 mb-2">Required for red decisions. Why is this decision being made despite misalignment?</p>
                                <textarea name="justification" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('justification') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Decision Date') }} (optional)</label>
                                <input type="date" name="decision_date" value="{{ old('decision_date', now()->format('Y-m-d')) }}"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <x-primary-button>{{ __('Log Decision') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
