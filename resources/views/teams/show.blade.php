<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('teams.index') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium mb-4 inline-block">
                    ← Terug naar teams
                </a>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $team->name }}</h1>
                <p class="text-gray-600">Team details en informatie</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Team informatie</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Gemaakt door</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $team->createdBy->name ?? 'Onbekend' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Aantal toernooien</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $team->tournaments->count() ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Team leden</h2>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $team->players->count() }} {{ $team->players->count() === 1 ? 'speler' : 'spelers' }}
                    </span>
                </div>

                @if ($team->players && $team->players->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($team->players as $player)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold text-lg">
                                                {{ strtoupper(substr($player->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate">
                                            {{ $player->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Speler #{{ $loop->iteration }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="mt-2 text-gray-500">Dit team heeft nog geen spelers</p>
                    </div>
                @endif
            </div>

            @if ($team->tournaments && $team->tournaments->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deelnemende toernooien</h2>
                    <div class="space-y-3">
                        @foreach ($team->tournaments as $tournament)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $tournament->name }}</p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d-m-Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('tournament.show', $tournament->id) }}"
                                        class="text-blue-600 hover:text-blue-700 font-medium">
                                        Bekijken →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex gap-4 mt-6">
                <a href="{{ route('teams.edit', $team->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                    Team bewerken
                </a>
                <form action="{{ route('teams.destroy', $team->id) }}" method="POST"
                    onsubmit="return confirm('Weet je zeker dat je dit team wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                        Team verwijderen
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>