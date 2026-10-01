@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Levering Informatie</h1>

        <div class="mb-6 p-4 bg-gray-50 rounded">
            <p class="text-lg"><strong>Naam product:</strong> {{ $product->Naam }}</p>
            <p class="text-lg"><strong>Barcode:</strong> {{ $product->Barcode }}</p>
        </div>

        <p class="text-lg mb-4">
            Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende
            levering is: {{ $verwachteLeveringsdatum ?? 'niet bekend' }}
        </p>

        <p class="text-gray-600">
            U wordt over 4 seconden teruggestuurd naar het overzicht, of
            <a href="{{ route('magazijn.index') }}" class="text-blue-600 hover:underline">klik hier</a>.
        </p>
    </div>
@endsection

@push('head')
    <meta http-equiv="refresh" content="4;url={{ route('magazijn.index') }}">
@endpush