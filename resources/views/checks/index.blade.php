<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Monthly Vision Checks') }}
            </h2>
            <a href="{{ route('checks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('New Vision Check') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($checks->count())
                <div class="space-y-4">
                    @foreach($checks as $check)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $check->check_date->format('F Y') }}</h3>
                                            <span class="text-sm text-gray-400">{{ $check->check_date->format('M d, Y') }}</span>
                                        </div>

                                        <div class="mt-3 space-y-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-600">{{ __('Paying into vision?') }}</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    {{ $check->q1_answer === 'yes' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $check->q1_answer === 'partially' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $check->q1_answer === 'no' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $check->q1_answer === 'yes' ? __('Yes') : ($check->q1_answer === 'partially' ? __('Partially') : __('No')) }}
                                                </span>
                                            </div>

                                            @if($check->actionItems->count())
                                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                                    <span>{{ $check->actionItems->where('completed', true)->count() }}/{{ $check->actionItems->count() }} {{ __('action items completed') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-3 ml-4">
                                        <a href="{{ route('checks.show', $check) }}" class="text-sm text-indigo-600 hover:text-indigo-800">{{ __('View') }} &rarr;</a>
                                        <form method="POST" action="{{ route('checks.destroy', $check) }}" onsubmit="return confirm('Delete this vision check?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $checks->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <p class="mb-2">{{ __('No vision checks yet.') }}</p>
                        <p class="text-sm">{{ __('Monthly vision checks keep your strategy alive. Spend 15 minutes each month reflecting on alignment.') }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
