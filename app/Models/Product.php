<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $table = 'Product';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Barcode',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    /**
     * The stock records of this product, one per packaging unit.
     */
    public function magazijn(): HasMany
    {
        return $this->hasMany(Magazijn::class, 'ProductId', 'Id');
    }

    /**
     * The allergens linked to this product through ProductPerAllergeen.
     */
    public function allergenen(): BelongsToMany
    {
        return $this->belongsToMany(
            Allergeen::class,
            'ProductPerAllergeen',
            'ProductId',
            'AllergeenId',
            'Id',
            'Id',
        )->withPivot(['IsActief', 'Opmerking', 'DatumAangemaakt', 'DatumGewijzigd']);
    }

    /**
     * The deliveries of this product through ProductPerLeverancier.
     */
    public function leveringen(): HasMany
    {
        return $this->hasMany(ProductPerLeverancier::class, 'ProductId', 'Id');
    }

    /**
     * Limit the query to active products.
     */
    public function scopeActief(Builder $query): Builder
    {
        return $query->where('IsActief', true);
    }

    /**
     * The active stock records of this product.
     *
     * @return Collection<int, Magazijn>
     */
    public function actieveMagazijnRecords(): Collection
    {
        return $this->relationLoaded('magazijn')
            ? $this->magazijn->filter(fn (Magazijn $magazijn) => $magazijn->IsActief)->values()
            : $this->magazijn()->where('IsActief', true)->get();
    }

    /**
     * The total number of units in stock, summed over all active stock records.
     */
    public function totaleVoorraad(): int
    {
        return (int) $this->actieveMagazijnRecords()
            ->sum(fn (Magazijn $magazijn) => (int) $magazijn->AantalAanwezig);
    }

    /**
     * Whether any units of this product are in stock.
     */
    public function heeftVoorraad(): bool
    {
        return $this->totaleVoorraad() > 0;
    }

    /**
     * The active deliveries, oldest delivery first.
     *
     * @return Collection<int, ProductPerLeverancier>
     */
    public function actieveLeveringen(): Collection
    {
        $leveringen = $this->relationLoaded('leveringen')
            ? $this->leveringen
            : $this->leveringen()->with('leverancier')->get();

        return $leveringen
            ->filter(fn (ProductPerLeverancier $levering) => $levering->IsActief)
            ->sortBy('DatumLevering')
            ->values();
    }

    /**
     * The most recent delivery, which decides the next expected delivery date.
     */
    public function laatsteLevering(): ?ProductPerLeverancier
    {
        return $this->actieveLeveringen()->sortByDesc('DatumLevering')->first();
    }

    /**
     * The expected next delivery date, or null when nothing is scheduled.
     */
    public function verwachteLeveringsdatum(): ?string
    {
        $leveringen = $this->actieveLeveringen()
            ->filter(fn (ProductPerLeverancier $levering) => $levering->DatumEerstVolgendeLevering !== null)
            ->sortByDesc('DatumEerstVolgendeLevering');

        return $leveringen->first()?->DatumEerstVolgendeLevering?->format('d-m-Y');
    }

    /**
     * The active allergens, alphabetically.
     *
     * @return Collection<int, Allergeen>
     */
    public function actieveAllergenen(): Collection
    {
        $allergenen = $this->relationLoaded('allergenen')
            ? $this->allergenen
            : $this->allergenen()->where('ProductPerAllergeen.IsActief', true)->get();

        return $allergenen
            ->filter(fn (Allergeen $allergeen) => $allergeen->pivot->IsActief && $allergeen->IsActief)
            ->sortBy('Naam')
            ->values();
    }

    protected function casts(): array
    {
        return [
            'IsActief' => 'boolean',
            'DatumAangemaakt' => 'datetime',
            'DatumGewijzigd' => 'datetime',
        ];
    }
}
