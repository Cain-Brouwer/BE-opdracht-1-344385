<?php

namespace App\Models;

use Database\Factories\ShopProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Product in the shop catalogue (table `products`).
 *
 * The Jamin warehouse uses the capitalised `Product` table, see {@see Product}.
 */
class ShopProduct extends Model
{
    /** @use HasFactory<ShopProductFactory> */
    use HasFactory;

    protected $table = 'products';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
