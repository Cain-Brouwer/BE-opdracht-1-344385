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
     *
     * Zonder voorraad blijft het scherm staan, maar toont de tabel de melding
     * dat er geen voorraad aanwezig is.
     */
    public function leveringsinformatie(Product $product): View
    {
        abort_unless($product->IsActief, 404);

        $product->loadMissing(['magazijn', 'leveringen.leverancier']);

        $leveringen = $product->heeftVoorraad()
            ? $product->actieveLeveringen()
            : $product->actieveLeveringen()->take(0);

        return view('magazijn.leveringsinformatie', [
            'product' => $product,
            'leveringen' => $leveringen,
            'leverancier' => $product->laatsteLevering()?->leverancier,
            'verwachteLeveringsdatum' => $product->verwachteLeveringsdatum(),
        ]);
    }

    /**
     * Overzicht Allergenen: alle allergenen van het gekozen product,
     * gesorteerd op Naam oplopend.
     *
     * Zonder allergenen blijft het scherm staan, maar toont de tabel de melding
     * dat er geen stoffen in zitten die een allergische reactie veroorzaken.
     */
    public function allergenen(Product $product): View
    {
        abort_unless($product->IsActief, 404);

        $product->loadMissing(['allergenen']);

        $allergenen = $product->actieveAllergenen();

        return view('magazijn.overzicht-allergenen', [
            'product' => $product,
            'allergenen' => $allergenen,
        ]);
    }
}
