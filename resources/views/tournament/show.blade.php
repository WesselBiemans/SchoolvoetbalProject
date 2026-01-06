<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('tournament.index') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium mb-4 inline-block">
                    ← Terug naar toernooien
                </a>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $tournament->name }}</h1>
                <p class="text-gray-600">{{ $tournament->description }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Toernooi informatie</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Startdatum</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d-m-Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Aantal teams</p>
                        <p class="text-lg font-medium text-gray-900">{{ $tournament->teams->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Aantal wedstrijden</p>
                        <p class="text-lg font-medium text-gray-900">{{ $tournament->matches->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Deelnemende teams</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse ($tournament->teams as $team)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <p class="font-medium text-gray-900">{{ $team->name }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-2">Geen teams gevonden</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Wedstrijden</h2>
                <div class="space-y-3">
                    @forelse ($tournament->matches as $match)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">
                                        {{ $match->team1->name ?? 'Team 1' }}
                                        <span class="text-gray-500">vs</span>
                                        {{ $match->team2->name ?? 'Team 2' }}
                                    </p>
                                    @if ($match->match_date)
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($match->match_date)->format('d-m-Y H:i') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900">
                                        {{ $match->team_1_score }} - {{ $match->team_2_score }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Geen wedstrijden gepland</p>
                    @endforelse
                </div>
            </div>

            <div class="flex gap-4 mt-6">
                <a href="{{ route('tournament.edit', $tournament->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                    Toernooi bewerken
                </a>
                <form action="{{ route('tournament.destroy', $tournament->id) }}" method="POST"
                    onsubmit="return confirm('Weet je zeker dat je dit toernooi wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                        Toernooi verwijderen
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
