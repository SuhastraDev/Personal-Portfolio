<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasTranslation;

class ProductCategory extends Model
{
    use HasTranslation;

    protected $fillable = [
        'name',
        'name_en',
        'slug',
    ];

    /**
     * Produk dalam kategori ini.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
