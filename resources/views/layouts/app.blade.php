<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @fonts
    @stack('head')
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body { font-family: system-ui, sans-serif; }
        </style>
    @endif
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="font-bold text-lg">{{ config('app.name') }}</a>
            <div class="flex gap-4 items-center">
                <a href="{{ route('categories.index') }}" class="text-sm text-gray-700 hover:underline">Categorieën</a>

                @auth
                    @role('magazijnmedewerker|admin')
                        <a href="{{ route('magazijn.index') }}" class="text-sm text-gray-700 hover:underline">
                            Overzicht Magazijn Jamin
                        </a>
                    @endrole
                    <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ Auth::user()->roles->pluck('name')->join(', ') }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">Uitloggen</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Inloggen</a>
                    <a href="{{ route('register') }}" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Registreren</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-4xl mx-auto px-4 py-8 w-full">
        @if (session('status'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-100 text-red-800 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>