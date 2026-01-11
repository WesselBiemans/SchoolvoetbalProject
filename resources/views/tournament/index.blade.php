<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Toernooien</h1>
                    <p class="text-gray-600">Overzicht van alle toernooien</p>
                </div>
                <a href="{{ route('tournament.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                    + Nieuw Toernooi
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @forelse ($tournament as $item)
                <div
                    class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6 hover:shadow-xl transition duration-200">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $item->name }}</h2>
                                <p class="text-gray-600 mb-4">{{ $item->description }}</p>

                                <div class="flex items-center gap-6 text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>{{ $item->teams->count() }} teams</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $item->matches->count() }} wedstrijden</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2 ml-4">
                                <a href="{{ route('tournament.show', $item->id) }}"
                                    class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-4 rounded-lg transition duration-150">
                                    Bekijken
                                </a>
                                <a href="{{ route('tournament.edit', $item->id) }}"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-150">
                                    Bewerken
                                </a>
                                <form action="{{ route('tournament.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Weet je zeker dat je dit toernooi wilt verwijderen?');">
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
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Geen toernooien gevonden</h3>
                    <p class="text-gray-600 mb-6">Begin met het aanmaken van je eerste toernooi</p>
                    <a href="{{ route('tournament.create') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                        Maak je eerste toernooi
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
