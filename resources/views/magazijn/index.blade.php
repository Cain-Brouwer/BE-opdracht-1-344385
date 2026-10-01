@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Overzicht Magazijn Jamin</h1>
            <span class="text-sm text-gray-600">Gesorteerd op barcode oplopend</span>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Naam product</th>
                    <th class="border px-4 py-2 text-left">Barcode</th>
                    <th class="border px-4 py-2 text-left">Verpakkingseenheid</th>
                    <th class="border px-4 py-2 text-left">Aantal aanwezig</th>
                    <th class="border px-4 py-2 text-center">Leverantie info</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($producten as $product)
                    <tr>
                        <td class="border px-4 py-2 font-medium">{{ $product->Naam }}</td>
                        <td class="border px-4 py-2">{{ $product->Barcode }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($product->actieveMagazijnRecords() as $magazijn)
                                {{ rtrim(rtrim(number_format((float) $magazijn->Verpakkingseenheid, 2, ',', ''), '0'), ',') }} kg
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            @if ($product->heeftVoorraad())
                                {{ $product->totaleVoorraad() }}
                            @else
                                <span class="text-gray-500">geen voorraad</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('magazijn.leveringsinformatie', $product) }}"
                               title="Leverantie info" aria-label="Leverantie info van {{ $product->Naam }}"
                               class="text-2xl text-blue-600 hover:text-blue-800">?</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-2 text-gray-500">
                            Er staan op dit moment geen producten in het magazijn.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection