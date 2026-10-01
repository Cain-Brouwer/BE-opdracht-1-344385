@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Levering Informatie</h1>
            <a href="{{ route('magazijn.index') }}" class="text-sm text-blue-600 hover:underline">
                Terug naar overzicht
            </a>
        </div>

        <div class="mb-6 p-4 bg-gray-50 rounded">
            <p class="text-lg"><strong>Naam product:</strong> {{ $product->Naam }}</p>
            <p class="text-lg"><strong>Barcode:</strong> {{ $product->Barcode }}</p>
        </div>

        @if ($leverancier)
            <div class="mb-6 p-4 bg-blue-50 rounded">
                <p class="text-lg"><strong>Naam leverancier:</strong> {{ $leverancier->Naam }}</p>
                <p class="text-lg">
                    <strong>Contactpersoon leverancier:</strong> {{ $leverancier->ContactPersoon }}
                </p>
                <p class="text-lg">
                    <strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer }}
                </p>
                <p class="text-lg"><strong>Mobiel:</strong> {{ $leverancier->Mobiel }}</p>
            </div>
        @endif

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Datum laatste levering</th>
                    <th class="border px-4 py-2 text-left">Aantal</th>
                    <th class="border px-4 py-2 text-left">Verwachte eerstvolgende levering</th>
                    <th class="border px-4 py-2 text-left">Leverancier</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leveringen as $levering)
                    <tr>
                        <td class="border px-4 py-2">{{ $levering->DatumLevering->format('d-m-Y') }}</td>
                        <td class="border px-4 py-2">{{ $levering->Aantal }}</td>
                        <td class="border px-4 py-2">
                            {{ $levering->DatumEerstVolgendeLevering?->format('d-m-Y') ?? 'onbekend' }}
                        </td>
                        <td class="border px-4 py-2">{{ $levering->leverancier?->Naam ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-4 py-2 text-gray-500">
                            Voor dit product zijn er geen leveringen vastgelegd.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection