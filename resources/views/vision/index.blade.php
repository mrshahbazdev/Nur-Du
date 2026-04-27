<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vision & Guiding Principles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Vision Statement --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Vision Statement</h3>
                    <p class="text-sm text-gray-500 mb-4">One clear vision statement (max 2 lines) that everyone can understand.</p>

                    <form method="POST" action="{{ route('vision.store') }}">
                        @csrf
                        <div class="mb-4">
                            <textarea name="statement" rows="3"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g. We will become the most reliable partner for X, measurably saving customer Y time and costs."
                                required>{{ old('statement', $vision?->statement) }}</textarea>
                            @error('statement')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <x-primary-button>{{ $vision ? 'Update Vision' : 'Save Vision' }}</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- Guiding Principles --}}
            @if($vision)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Guiding Principles</h3>
                        <p class="text-sm text-gray-500 mb-4">3&ndash;5 principles that explain how you achieve your vision.</p>

                        @if($vision->guidingPrinciples->count())
                            <div class="space-y-4 mb-6">
                                @foreach($vision->guidingPrinciples as $principle)
                                    <div class="border border-gray-200 rounded-lg p-4" x-data="{ editing: false }">
                                        <div x-show="!editing">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $principle->title }}</p>
                                                    @if($principle->description)
                                                        <p class="text-sm text-gray-500 mt-1">{{ $principle->description }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button @click="editing = true" class="text-sm text-indigo-600 hover:text-indigo-800">Edit</button>
                                                    <form method="POST" action="{{ route('vision.principles.destroy', $principle) }}" onsubmit="return confirm('Remove this principle?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div x-show="editing" x-cloak>
                                            <form method="POST" action="{{ route('vision.principles.update', $principle) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="space-y-3">
                                                    <input type="text" name="title" value="{{ $principle->title }}"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                    <textarea name="description" rows="2"
                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        placeholder="Optional description">{{ $principle->description }}</textarea>
                                                    <div class="flex space-x-2">
                                                        <x-primary-button>Save</x-primary-button>
                                                        <button type="button" @click="editing = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($vision->guidingPrinciples->count() < 5)
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Add Principle</h4>
                                <form method="POST" action="{{ route('vision.principles.store') }}">
                                    @csrf
                                    <div class="space-y-3">
                                        <input type="text" name="title" placeholder="e.g. Customer value over internal convenience"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <textarea name="description" rows="2" placeholder="Optional description"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                        @error('title')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                        <x-primary-button>Add Principle</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mt-4">Maximum of 5 guiding principles reached.</p>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
