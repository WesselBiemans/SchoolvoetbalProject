<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('teams.index') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium mb-4 inline-block">
                    ← Terug naar teams
                </a>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $teams->name }}</h1>
                <p class="text-gray-600">Team details en informatie</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Team informatie</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Gemaakt door</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $teams->createdBy->name ?? 'Onbekend' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Aantal toernooien</p>
                        <p class="text-lg font-medium text-gray-900">
                            {{ $teams->tournaments->count() ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            @if ($teams->tournaments && $teams->tournaments->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deelnemende toernooien</h2>
                    <div class="space-y-3">
                        @foreach ($teams->tournaments as $tournament)
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
                <a href="{{ route('teams.edit', $teams->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                    Team bewerken
                </a>
                <form action="{{ route('teams.destroy', $teams->id) }}" method="POST"
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
