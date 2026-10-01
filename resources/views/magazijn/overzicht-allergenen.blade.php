@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Overzicht Allergenen</h1>

        <div class="mb-6 p-4 bg-gray-50 rounded">
            <p class="text-lg"><strong>Naam product:</strong> {{ $product->Naam }}</p>
            <p class="text-lg"><strong>Barcode:</strong> {{ $product->Barcode }}</p>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Naam allergene</th>
                    <th class="border px-4 py-2 text-left">Omschrijving</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($allergenen as $allergeen)
                    <tr>
                        <td class="border px-4 py-2 font-medium">{{ $allergeen->Naam }}</td>
                        <td class="border px-4 py-2">{{ $allergeen->Omschrijving }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border px-4 py-2 text-gray-500">
                            In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p class="mt-4">
            <a href="{{ route('magazijn.index') }}" class="text-blue-600 hover:underline">
                Terug naar overzicht
            </a>
        </p>
    </div>
@endsection