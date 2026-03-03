<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasTranslation;

class PortfolioCategory extends Model
{
    use HasTranslation;

    protected $fillable = [
        'name',
        'name_en',
        'slug',
    ];

    /**
     * Portfolio yang termasuk dalam kategori ini.
     */
    public function portfolios(): BelongsToMany
    {
        return $this->belongsToMany(Portfolio::class, 'portfolio_category', 'category_id', 'portfolio_id');
    }
}
