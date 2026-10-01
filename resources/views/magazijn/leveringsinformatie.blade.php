@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Levering Informatie</h1>

        <div class="mb-6 p-4 bg-gray-50 rounded">
            <p class="text-lg"><strong>Naam leverancier:</strong> {{ $leverancier?->Naam ?? '-' }}</p>
            <p class="text-lg">
                <strong>Contactpersoon leverancier:</strong> {{ $leverancier?->ContactPersoon ?? '-' }}
            </p>
            <p class="text-lg">
                <strong>Leveranciernummer:</strong> {{ $leverancier?->LeverancierNummer ?? '-' }}
            </p>
            <p class="text-lg"><strong>Mobiel:</strong> {{ $leverancier?->Mobiel ?? '-' }}</p>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Naam Product</th>
                    <th class="border px-4 py-2 text-left">Datum laatste levering</th>
                    <th class="border px-4 py-2 text-left">Aantal</th>
                    <th class="border px-4 py-2 text-left">Eerstvolgende levering</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leveringen as $levering)
                    <tr>
                        <td class="border px-4 py-2 font-medium">{{ $product->Naam }}</td>
                        <td class="border px-4 py-2">{{ $levering->DatumLevering->format('d-m-Y') }}</td>
                        <td class="border px-4 py-2">{{ $levering->Aantal }}</td>
                        <td class="border px-4 py-2">
                            {{ $levering->DatumEerstVolgendeLevering?->format('d-m-Y') ?? 'onbekend' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-4 py-2">
                            {{ 'Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: '.($verwachteLeveringsdatum ?? 'niet bekend') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p class="mt-4 text-gray-600">
            @if ($leveringen->isEmpty())
                U wordt over 4 seconden teruggestuurd naar het overzicht.
            @endif
            <a href="{{ route('magazijn.index') }}" class="text-blue-600 hover:underline">
                Terug naar overzicht
            </a>
        </p>
    </div>
@endsection

@if ($leveringen->isEmpty())
    @push('head')
        <meta http-equiv="refresh" content="4;url={{ route('magazijn.index') }}">
    @endpush
@endif