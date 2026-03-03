<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslation;

class Service extends Model
{
    use HasTranslation;

    protected $fillable = [
        'title',
        'title_en',
        'description',
        'description_en',
        'icon',
        'price_start',
        'price_end',
        'is_active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'price_start' => 'decimal:2',
            'price_end' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope: only active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: order by 'order' column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Format harga range.
     */
    public function getFormattedPriceRangeAttribute(): string
    {
        $start = 'Rp ' . number_format($this->price_start, 0, ',', '.');
        if ($this->price_end) {
            $end = 'Rp ' . number_format($this->price_end, 0, ',', '.');
            return "{$start} - {$end}";
        }
        return "Mulai dari {$start}";
    }
}
