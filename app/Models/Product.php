<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasTranslation;

class Product extends Model
{
    use HasTranslation;

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'description',
        'description_en',
        'features',
        'features_en',
        'tech_stack',
        'price',
        'thumbnail',
        'file_path',
        'demo_url',
        'version',
        'category_id',
        'is_active',
        'download_count',
        'meta_title',
        'meta_title_en',
        'meta_description',
        'meta_description_en',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Safe accessor for features (handles double-encoded JSON).
     */
    protected function features(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value): array => self::safeJsonArray($value),
            set: fn(mixed $value) => is_array($value) ? json_encode($value) : $value,
        );
    }

    /**
     * Safe accessor for features_en (handles double-encoded JSON).
     */
    protected function featuresEn(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value): array => self::safeJsonArray($value),
            set: fn(mixed $value) => is_array($value) ? json_encode($value) : $value,
        );
    }

    /**
     * Safe accessor for tech_stack (handles double-encoded JSON).
     */
    protected function techStack(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value): array => self::safeJsonArray($value),
            set: fn(mixed $value) => is_array($value) ? json_encode($value) : $value,
        );
    }

    /**
     * Kategori produk.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Tag produk.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ProductTag::class, 'product_tag', 'product_id', 'tag_id');
    }

    /**
     * Gambar preview/screenshot produk.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Order/transaksi produk ini.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope: only active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Format harga ke Rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
