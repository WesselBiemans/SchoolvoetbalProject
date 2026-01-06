<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Teams</h1>
                    <p class="text-gray-600">Overzicht van alle teams</p>
                </div>
                <a href="{{ route('teams.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                    + Nieuw Team
                </a>
            </div>


            @forelse ($team as $item)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6 hover:shadow-xl transition duration-200">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $item->name }}</h2>

                                <div class="flex items-center gap-6 text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <span>Gemaakt door {{ $item->createdBy->name ?? 'Onbekend' }}</span>
                                    </div>

                                    @if ($item->tournaments)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $item->tournaments->count() }} toernooien</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2 ml-4">
                                <a href="{{ route('teams.show', $item->id) }}"
                                    class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-4 rounded-lg transition duration-150">
                                    Bekijken
                                </a>
                                <a href="{{ route('teams.edit', $item->id) }}"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-150">
                                    Bewerken
                                </a>
                                <form action="{{ route('teams.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Weet je zeker dat je dit team wilt verwijderen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-4 rounded-lg transition duration-150">
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Geen teams gevonden</h3>
                    <p class="text-gray-600 mb-6">Begin met het aanmaken van je eerste team</p>
                    <a href="{{ route('teams.create') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                        Maak je eerste team
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
