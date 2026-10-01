<?php

namespace App\Models;

use Database\Factories\AllergeenFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    /** @use HasFactory<AllergeenFactory> */
    use HasFactory;

    protected $table = 'Allergeen';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Omschrijving',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    /**
     * The products this allergen is linked to.
     */
    public function producten(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'ProductPerAllergeen',
            'AllergeenId',
            'ProductId',
            'Id',
            'Id',
        )->withPivot(['IsActief', 'Opmerking', 'DatumAangemaakt', 'DatumGewijzigd']);
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
