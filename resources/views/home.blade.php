<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6">
                    Schoolvoetbal Platform
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Beheer toernooien, teams en wedstrijden op één plek
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('tournaments.index') }}"
                        class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-4 px-8 rounded-lg transition duration-200 shadow-xl hover:shadow-2xl">
                        Bekijk Toernooien
                    </a>
                    <a href="{{ route('teams.index') }}"
                        class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-4 px-8 rounded-lg transition duration-200 shadow-xl hover:shadow-2xl">
                        Alle Teams
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">
                Wat kun je doen?
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition duration-200">
                    <div class="text-5xl mb-4">⚽</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Toernooien Organiseren</h3>
                    <p class="text-gray-600 mb-4">
                        Maak en beheer schoolvoetbal toernooien met gemak. Plan wedstrijden, volg standen en meer.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition duration-200">
                    <div class="text-5xl mb-4">👥</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Teams Beheren</h3>
                    <p class="text-gray-600 mb-4">
                        Registreer teams, beheer spelers en houd prestaties bij. Alles overzichtelijk op één plek.
                    </p>
                    <a href="{{ route('teams.create') }}"
                        class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                        Nieuw team →
                    </a>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition duration-200">
                    <div class="text-5xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Uitslagen & Statistieken</h3>
                    <p class="text-gray-600 mb-4">
                        Volg live scores, bekijk wedstrijdresultaten en analyseer team prestaties in real-time.
                    </p>
                    <a href="{{ route('matches.index') }}"
                        class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                        Bekijk wedstrijden →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="bg-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-6">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-2">
                        {{ \App\Models\Tournament::count() }}
                    </div>
                    <div class="text-gray-600 font-semibold">Toernooien</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl md:text-5xl font-bold text-green-600 mb-2">
                        {{ \App\Models\Teams::count() }}
                    </div>
                    <div class="text-gray-600 font-semibold">Teams</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl md:text-5xl font-bold text-purple-600 mb-2">
                        {{ \App\Models\Matches::count() }}
                    </div>
                    <div class="text-gray-600 font-semibold">Wedstrijden</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl md:text-5xl font-bold text-orange-600 mb-2">
                        {{ \App\Models\Players::count() }}
                    </div>
                    <div class="text-gray-600 font-semibold">Spelers</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Klaar om te beginnen?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Start vandaag nog met het organiseren van jouw schoolvoetbal toernooi
            </p>
        </div>
    </div>
</x-app-layout>
