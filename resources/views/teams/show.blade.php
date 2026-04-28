<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $team->name }} — {{ __('Team Settings') }}</h2>
            <a href="{{ route('teams.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← {{ __('All Teams') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            {{-- Team Name --}}
            @if($isAdmin)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Team Name') }}</h3>
                        <form method="POST" action="{{ route('teams.update', $team) }}">
                            @csrf
                            @method('PUT')
                            <div class="flex items-end space-x-3">
                                <div class="flex-1">
                                    <x-text-input name="name" type="text" class="block w-full" :value="$team->name" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Members --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Members') }} ({{ $members->count() }})</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Role') }}</th>
                                    @if($isAdmin)
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($members as $member)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $member->user->name }}
                                            @if($member->user_id === $team->owner_id)
                                                <span class="ml-1 text-xs text-indigo-600">({{ __('Owner') }})</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($isAdmin && $member->user_id !== $team->owner_id)
                                                <form method="POST" action="{{ route('teams.members.role', [$team, $member]) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        <option value="admin" {{ $member->role === 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                                                        <option value="manager" {{ $member->role === 'manager' ? 'selected' : '' }}>{{ __('Manager') }}</option>
                                                        <option value="member" {{ $member->role === 'member' ? 'selected' : '' }}>{{ __('Member') }}</option>
                                                    </select>
                                                </form>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $member->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($member->role === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ __(\Illuminate\Support\Str::ucfirst($member->role)) }}
                                                </span>
                                            @endif
                                        </td>
                                        @if($isAdmin)
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                                @if($member->user_id !== $team->owner_id)
                                                    <form method="POST" action="{{ route('teams.members.remove', [$team, $member]) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">{{ __('Remove') }}</button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Invite Member --}}
            @if($isAdmin)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Invite Member') }}</h3>
                        <form method="POST" action="{{ route('teams.invitations.store', $team) }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" placeholder="user@example.com" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="role" :value="__('Role')" />
                                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="member">{{ __('Member') }}</option>
                                        <option value="manager">{{ __('Manager') }}</option>
                                        <option value="admin">{{ __('Admin') }}</option>
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <x-primary-button class="w-full justify-center">{{ __('Send Invitation') }}</x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Pending Invitations --}}
                @if($invitations->count())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Pending Invitations') }}</h3>
                            <div class="space-y-3">
                                @foreach($invitations as $invitation)
                                    <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">{{ $invitation->email }}</span>
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                {{ $invitation->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($invitation->role === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ __(\Illuminate\Support\Str::ucfirst($invitation->role)) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="text-xs text-gray-500">{{ $invitation->created_at->diffForHumans() }}</span>
                                            <form method="POST" action="{{ route('teams.invitations.cancel', [$team, $invitation]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">{{ __('Cancel') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 p-3 bg-indigo-50 rounded-lg">
                                <p class="text-sm text-indigo-700">
                                    {{ __('Share invitation link') }}:
                                    <span class="font-mono text-xs break-all">{{ route('invitations.accept', $invitations->first()->token) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Delete Team --}}
                @if(Auth::id() === $team->owner_id)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-red-600 mb-2">{{ __('Delete Team') }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ __('Once a team is deleted, all of its data will be permanently removed.') }}</p>
                            <form method="POST" action="{{ route('teams.destroy', $team) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this team?') }}')">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>{{ __('Delete Team') }}</x-danger-button>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
