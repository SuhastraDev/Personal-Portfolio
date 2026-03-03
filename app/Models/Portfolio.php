<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasTranslation;

class Portfolio extends Model
{
    use HasTranslation;

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'description',
        'description_en',
        'thumbnail',
        'url',
        'client_name',
        'tech_stack',
        'completion_date',
        'is_featured',
        'order',
        'meta_title',
        'meta_title_en',
        'meta_description',
        'meta_description_en',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'completion_date' => 'date',
        ];
    }

    /**
     * Safe accessor for tech_stack (handles double-encoded JSON).
     */
    protected function techStack(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value): array {
                return self::safeJsonArray($value);
            },
            set: fn(mixed $value) => is_array($value) ? json_encode($value) : $value,
        );
    }

    /**
     * Safely decode JSON that may be double-encoded.
     */
    public static function safeJsonArray(mixed $value): array
    {
        if (is_array($value)) return $value;
        if (!is_string($value) || $value === '') return [];

        $decoded = json_decode($value, true);
        if (is_array($decoded)) return $decoded;

        // Handle double-encoded: json string containing json string
        if (is_string($decoded)) {
            $second = json_decode($decoded, true);
            return is_array($second) ? $second : [];
        }

        return [];
    }

    /**
     * Kategori portfolio.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PortfolioCategory::class, 'portfolio_category', 'portfolio_id', 'category_id');
    }

    /**
     * Gambar galeri portfolio.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class)->orderBy('order');
    }

    /**
     * Scope: only featured.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: order by 'order' column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
