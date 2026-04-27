<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Vision Check') }} &mdash; {{ $check->check_date->format('F d, Y') }}
            </h2>
            <a href="{{ route('checks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">&larr; {{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Answers --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-900 mb-2">1. {{ __('Does what we are doing now clearly pay into our vision?') }}</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $check->q1_answer === 'yes' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $check->q1_answer === 'partially' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $check->q1_answer === 'no' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $check->q1_answer === 'yes' ? __('Yes') : ($check->q1_answer === 'partially' ? __('Partially') : __('No')) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-900 mb-2">2. {{ __('What decision or activity is currently most moving us away from the vision?') }}</p>
                        <p class="text-gray-700">{{ $check->q2_answer ?: 'No answer provided.' }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-900 mb-2">3. {{ __('What is the one thing we need to change in the next period to get closer to the vision?') }}</p>
                        <p class="text-gray-700">{{ $check->q3_answer ?: 'No answer provided.' }}</p>
                    </div>

                    @if($check->notes)
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">{{ __('Additional Notes') }}:</p>
                            <p class="text-gray-600">{{ $check->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Action Items --}}
            @if($check->actionItems->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Action Items') }}</h3>
                        <div class="space-y-2">
                            @foreach($check->actionItems as $item)
                                <div class="flex items-center justify-between p-3 rounded-lg {{ $item->completed ? 'bg-green-50' : 'bg-gray-50' }}">
                                    <span class="{{ $item->completed ? 'line-through text-gray-400' : 'text-gray-900' }}">
                                        {{ $item->title }}
                                    </span>
                                    <form method="POST" action="{{ route('action-items.toggle', $item) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm {{ $item->completed ? 'text-gray-400 hover:text-gray-600' : 'text-indigo-600 hover:text-indigo-800' }}">
                                            {{ $item->completed ? __('Undo') : __('Complete') }}
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
