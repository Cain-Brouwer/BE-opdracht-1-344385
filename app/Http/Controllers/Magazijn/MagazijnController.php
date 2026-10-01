<?php

namespace App\Http\Controllers\Magazijn;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class MagazijnController extends Controller
{
    /**
     * Overzicht Magazijn Jamin: alle producten die in het magazijn aanwezig zijn,
     * gesorteerd op Barcode oplopend.
     */
    public function index(): View
    {
        $producten = Product::query()
            ->actief()
            ->whereHas('magazijn', fn ($query) => $query->where('IsActief', true))
            ->with(['magazijn' => fn ($query) => $query->where('IsActief', true)])
            ->orderBy('Barcode')
            ->get();

        return view('magazijn.index', [
            'producten' => $producten,
        ]);
    }

    /**
     * Levering Informatie: alle leveringsdata van het gekozen product,
     * gesorteerd op Datum laatste levering oplopend.
     */
    public function leveringsinformatie(Product $product): View
    {
        abort_unless($product->IsActief, 404);

        $product->loadMissing(['magazijn', 'leveringen.leverancier']);

        if (! $product->heeftVoorraad()) {
            return view('magazijn.leveringsinformatie-geen-voorraad', [
                'product' => $product,
                'verwachteLeveringsdatum' => $product->verwachteLeveringsdatum(),
            ]);
        }

        $leveringen = $product->actieveLeveringen();

        return view('magazijn.leveringsinformatie', [
            'product' => $product,
            'leveringen' => $leveringen,
            'leverancier' => $product->laatsteLevering()?->leverancier,
        ]);
    }

    /**
     * Overzicht Allergenen: alle allergenen van het gekozen product,
     * gesorteerd op Naam oplopend.
     */
    public function allergenen(Product $product): View
    {
        abort_unless($product->IsActief, 404);

        $product->loadMissing(['allergenen']);

        if ($product->actieveAllergenen()->isEmpty()) {
            return view('magazijn.overzicht-allergenen-geen-stoffen', [
                'product' => $product,
            ]);
        }

        return view('magazijn.overzicht-allergenen', [
            'product' => $product,
            'allergenen' => $product->actieveAllergenen(),
        ]);
    }
}
