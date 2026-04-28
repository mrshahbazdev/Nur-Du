<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Decision Alignment Log') }}
            </h2>
            <a href="{{ route('decisions.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Log Decision') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats Bar --}}
            @php $total = $stats['green'] + $stats['yellow'] + $stats['red']; @endphp
            @if($total > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center space-x-2">
                                <span class="w-4 h-4 rounded-full bg-green-500"></span>
                                <span class="text-sm text-gray-600">{{ __('Aligned') }}: <strong>{{ $stats['green'] }}</strong></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-4 h-4 rounded-full bg-yellow-400"></span>
                                <span class="text-sm text-gray-600">{{ __('Neutral') }}: <strong>{{ $stats['yellow'] }}</strong></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-4 h-4 rounded-full bg-red-500"></span>
                                <span class="text-sm text-gray-600">{{ __('Misaligned') }}: <strong>{{ $stats['red'] }}</strong></span>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-3 flex overflow-hidden">
                            <div class="bg-green-500 h-3" style="width: {{ ($stats['green'] / $total) * 100 }}%"></div>
                            <div class="bg-yellow-400 h-3" style="width: {{ ($stats['yellow'] / $total) * 100 }}%"></div>
                            <div class="bg-red-500 h-3" style="width: {{ ($stats['red'] / $total) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Decision List --}}
            @if($decisions->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="divide-y divide-gray-200">
                        @foreach($decisions as $decision)
                            <div class="p-6 flex items-start space-x-4">
                                <span class="mt-1 flex-shrink-0 w-4 h-4 rounded-full
                                    {{ $decision->alignment === 'green' ? 'bg-green-500' : '' }}
                                    {{ $decision->alignment === 'yellow' ? 'bg-yellow-400' : '' }}
                                    {{ $decision->alignment === 'red' ? 'bg-red-500' : '' }}">
                                </span>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-base font-medium text-gray-900">{{ $decision->title }}</h4>
                                        <span class="text-sm text-gray-400">{{ $decision->created_at->format('M d, Y') }}</span>
                                    </div>
                                    @if($decision->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $decision->description }}</p>
                                    @endif
                                    @if($decision->justification)
                                        <p class="text-sm text-gray-500 mt-1 italic">Justification: {{ $decision->justification }}</p>
                                    @endif
                                    <div class="mt-2 flex space-x-3">
                                        <a href="{{ route('decisions.edit', $decision) }}" class="text-sm text-indigo-600 hover:text-indigo-800">{{ __('Edit') }}</a>
                                        <form method="POST" action="{{ route('decisions.destroy', $decision) }}" onsubmit="return confirm('Delete this decision?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4">
                    {{ $decisions->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        {{ __('No decisions logged yet. Every major decision should get a vision alignment check.') }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
