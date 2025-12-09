

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>School voetbal</title>
    @vite('resources/css/app.css')

</head>

<body>
    <header class="w-full border-b bg-white">
        <nav class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

            <div class="text-xl font-semibold text-gray-700">
                School <span class="font-light">Voetbal</span>
            </div>

            <div class="hidden md:flex gap-8 text-gray-600">
                <a href="#" class="hover:text-gray-900">Home</a>
                <a href="#" class="hover:text-gray-900">Tournaments</a>
                <a href="#" class="hover:text-gray-900">Bets</a>
                <a href="#" class="hover:text-gray-900">Points</a>
                <a href="#" class="hover:text-gray-900">Profile</a>
            </div>



            <div class="flex gap-3">

                @if (Auth::check())
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1 border rounded-md text-gray-700 hover:bg-gray-50">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-4 py-1 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    Register
                </a>
                @endif
                
            </div>

        </nav>
    </header>



    <main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{ $slot }}
    </main>


    <footer class="w-full bg-black border-t border-gray-800 mt-12">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-gray-400 text-sm flex flex-col md:flex-row items-center justify-between">

            <p class="text-center md:text-left">
                © 2025 School Voetbal.
            </p>

            <div class="flex gap-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
                <a href="#" class="hover:text-white transition">Contact</a>
            </div>

        </div>
    </footer>


</body>

</html>
