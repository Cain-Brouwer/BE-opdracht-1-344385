<?php

namespace App\Models;

use Database\Factories\ProductPerAllergeenFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPerAllergeen extends Model
{
    /** @use HasFactory<ProductPerAllergeenFactory> */
    use HasFactory;

    protected $table = 'ProductPerAllergeen';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'ProductId',
        'AllergeenId',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

    public function allergeen(): BelongsTo
    {
        return $this->belongsTo(Allergeen::class, 'AllergeenId', 'Id');
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
