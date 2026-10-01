@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Categorieën</h1>

        <ul class="space-y-4">
            @forelse ($categories as $category)
                <li>
                    <h2 class="font-semibold text-lg">{{ $category->name }}</h2>

                    <ul class="list-disc list-inside text-gray-700">
                        @forelse ($category->products as $product)
                            <li>{{ $product->name }}</li>
                        @empty
                            <li class="text-gray-500">Geen producten in deze categorie.</li>
                        @endforelse
                    </ul>
                </li>
            @empty
                <li class="text-gray-500">Er zijn nog geen categorieën aangemaakt.</li>
            @endforelse
        </ul>
    </div>
@endsection