<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Team aanmaken</h1>
                <p class="text-gray-600">Vul de onderstaande gegevens in om een nieuw team te maken</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <div>
                            <h3 class="text-red-800 font-medium mb-2">Er zijn enkele problemen:</h3>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-700">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <form action="{{ route('teams.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Team naam
                        </label>
                        
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="Bijv. Team Phoenix" value="{{ old('name') }}" required>

                        <textarea
                                name="players"
                                id="players"
                                rows="5"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                                placeholder="Freek&#10;Sven&#10;Timmy&#10;Tommy"
                            >{{ old('players') }}</textarea>
                    </div>

                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Team aanmaken
                        </button>
                        <a href="{{ route('teams.index') }}"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                            Annuleren
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
