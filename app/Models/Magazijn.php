<?php

namespace App\Models;

use Database\Factories\MagazijnFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Magazijn extends Model
{
    /** @use HasFactory<MagazijnFactory> */
    use HasFactory;

    protected $table = 'Magazijn';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'ProductId',
        'Verpakkingseenheid',
        'AantalAanwezig',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    /**
     * The product this stock record belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

    protected function casts(): array
    {
        return [
            'Verpakkingseenheid' => 'decimal:2',
            'AantalAanwezig' => 'integer',
            'IsActief' => 'boolean',
            'DatumAangemaakt' => 'datetime',
            'DatumGewijzigd' => 'datetime',
        ];
    }
}
