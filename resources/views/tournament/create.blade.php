<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Toernooi aanmaken</h1>
                <p class="text-gray-600">Vul de onderstaande gegevens in om een nieuw toernooi te starten</p>
            </div>


            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <form action="{{ route('tournament.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Naam
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="Bijv. Zomer Kampioenschap 2024" value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Beschrijving
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none resize-none"
                            placeholder="Beschrijf het toernooi..." required>{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Startdatum
                        </label>
                        <input type="date" name="start_date" id="start_date"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none"
                            value="{{ old('start_date') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Selecteer teams
                        </label>
                        <p class="text-sm text-gray-500 mb-4">Minimaal 4 teams, even aantal vereist</p>

                        <div class="bg-gray-50 rounded-lg p-4 max-h-64 overflow-y-auto border border-gray-200">
                            <div class="space-y-2">
                                @forelse ($teams as $team)
                                    <label
                                        class="flex items-center p-3 rounded-lg hover:bg-white transition duration-150 cursor-pointer group">
                                        <input
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                                            type="checkbox" name="teams[]" value="{{ $team->id }}"
                                            id="team{{ $team->id }}"
                                            {{ in_array($team->id, old('teams', [])) ? 'checked' : '' }}>
                                        <span class="ml-3 text-gray-700 font-medium group-hover:text-gray-900">
                                            {{ $team->name }}
                                        </span>
                                    </label>
                                @empty
                                    <p class="text-gray-500 text-center py-4">Geen teams beschikbaar</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Toernooi aanmaken
                        </button>
                        <a href="{{ route('tournament.index') }}"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                            Annuleren
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
