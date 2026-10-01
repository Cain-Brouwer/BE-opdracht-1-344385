@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-2">Jamin</h1>
        <p class="text-gray-700 mb-6">
            Welkom bij de webapplicatie van Jamin. Log in als magazijnmedewerker om het overzicht van
            het magazijn te openen.
        </p>

        <a href="{{ route('magazijn.index') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Naar Overzicht Magazijn Jamin
        </a>

        @guest
            <a href="{{ route('login') }}" class="ml-3 text-blue-600 hover:underline">Inloggen</a>
        @endguest
    </div>
@endsection