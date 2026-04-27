<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Vision Check') }}
            </h2>
            <a href="{{ route('checks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">&larr; {{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-6">{{ __('Answer these 3 reflection questions honestly. This takes only 15 minutes.') }}</p>

                    <form method="POST" action="{{ route('checks.store') }}" x-data="{ items: [''] }">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Check Date') }}</label>
                                <input type="date" name="check_date" value="{{ old('check_date', now()->format('Y-m-d')) }}"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('check_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Question 1 --}}
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                    1. {{ __('Does what we are doing now clearly pay into our vision?') }}
                                </label>
                                <div class="flex space-x-4">
                                    @foreach(['yes' => __('Yes'), 'partially' => __('Partially'), 'no' => __('No')] as $value => $label)
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" name="q1_answer" value="{{ $value }}"
                                                class="text-indigo-600 focus:ring-indigo-500" {{ old('q1_answer') === $value ? 'checked' : '' }} required>
                                            <span class="text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('q1_answer')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Question 2 --}}
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                    2. {{ __('What decision or activity is currently most moving us away from the vision?') }}
                                </label>
                                <textarea name="q2_answer" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Describe the biggest misalignment...">{{ old('q2_answer') }}</textarea>
                            </div>

                            {{-- Question 3 --}}
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                    3. {{ __('What is the one thing we need to change in the next period to get closer to the vision?') }}
                                </label>
                                <textarea name="q3_answer" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="The single most important change...">{{ old('q3_answer') }}</textarea>
                            </div>

                            {{-- Notes --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Additional Notes') }} (optional)</label>
                                <textarea name="notes" rows="2"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            </div>

                            {{-- Action Items --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Action Items') }}</label>
                                <p class="text-xs text-gray-500 mb-3">Concrete next steps from this reflection.</p>
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <input type="text" :name="'action_items[' + index + ']'" x-model="items[index]"
                                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            placeholder="Action item...">
                                        <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                            class="text-red-400 hover:text-red-600 text-sm">&times;</button>
                                    </div>
                                </template>
                                <button type="button" @click="items.push('')" class="text-sm text-indigo-600 hover:text-indigo-800 mt-1">
                                    + {{ __('Add another') }}
                                </button>
                            </div>

                            <x-primary-button>{{ __('Save Vision Check') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
