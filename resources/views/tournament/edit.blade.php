<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('tournament.show', $tournament->id) }}"
                    class="text-blue-600 hover:text-blue-700 font-medium mb-4 inline-block">
                    ← Terug naar toernooi
                </a>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Toernooi bewerken</h1>
                <p class="text-gray-600">Pas de gegevens van het toernooi aan</p>
            </div>


            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <form action="{{ route('tournament.update', $tournament->id) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Naam
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="Bijv. Zomer Kampioenschap 2024" value="{{ old('name', $tournament->name) }}"
                            required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Beschrijving
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none resize-none"
                            placeholder="Beschrijf het toernooi..." required>{{ old('description', $tournament->description) }}</textarea>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Startdatum
                        </label>
                        <input type="date" name="start_date" id="start_date"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none"
                            value="{{ old('start_date', \Carbon\Carbon::parse($tournament->start_date)->format('Y-m-d')) }}"
                            required>
                    </div>

                    <input type="hidden" name="created_by" value="{{ $tournament->created_by }}">

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Toernooi bijwerken
                        </button>
                        <a href="{{ route('tournament.show', $tournament->id) }}"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                            Annuleren
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
