<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Decision') }}
            </h2>
            <a href="{{ route('decisions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">&larr; Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('decisions.update', $decision) }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Decision Title</label>
                                <input type="text" name="title" value="{{ old('title', $decision->title) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                                <textarea name="description" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $decision->description) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Vision Alignment</label>
                                <div class="grid grid-cols-3 gap-3">
                                    @php $alignment = old('alignment', $decision->alignment); @endphp
                                    <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none
                                        {{ $alignment === 'green' ? 'border-green-500 ring-2 ring-green-500' : 'border-gray-300' }}">
                                        <input type="radio" name="alignment" value="green" class="sr-only" {{ $alignment === 'green' ? 'checked' : '' }} required>
                                        <span class="flex flex-1 flex-col text-center">
                                            <span class="block w-8 h-8 rounded-full bg-green-500 mx-auto mb-2"></span>
                                            <span class="text-sm font-medium text-gray-900">Strengthens</span>
                                        </span>
                                    </label>
                                    <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none
                                        {{ $alignment === 'yellow' ? 'border-yellow-500 ring-2 ring-yellow-500' : 'border-gray-300' }}">
                                        <input type="radio" name="alignment" value="yellow" class="sr-only" {{ $alignment === 'yellow' ? 'checked' : '' }}>
                                        <span class="flex flex-1 flex-col text-center">
                                            <span class="block w-8 h-8 rounded-full bg-yellow-400 mx-auto mb-2"></span>
                                            <span class="text-sm font-medium text-gray-900">Neutral</span>
                                        </span>
                                    </label>
                                    <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none
                                        {{ $alignment === 'red' ? 'border-red-500 ring-2 ring-red-500' : 'border-gray-300' }}">
                                        <input type="radio" name="alignment" value="red" class="sr-only" {{ $alignment === 'red' ? 'checked' : '' }}>
                                        <span class="flex flex-1 flex-col text-center">
                                            <span class="block w-8 h-8 rounded-full bg-red-500 mx-auto mb-2"></span>
                                            <span class="text-sm font-medium text-gray-900">Weakens</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Justification</label>
                                <textarea name="justification" rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('justification', $decision->justification) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Decision Date</label>
                                <input type="date" name="decision_date" value="{{ old('decision_date', $decision->decision_date?->format('Y-m-d')) }}"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <x-primary-button>Update Decision</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
