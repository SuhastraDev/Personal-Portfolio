<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'product_id',
        'amount',
        'status',
        'payment_method',
        'payment_ref',
        'download_token',
        'download_count',
        'download_expires_at',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'download_expires_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Produk yang dibeli.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Generate nomor order unik.
     */
    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $rand = strtoupper(Str::random(4));
        $lastOrder = static::where('order_number', 'like', "INV-{$date}-%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr(Str::afterLast($lastOrder->order_number, '-'), 0, 3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return "INV-{$date}-" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . $rand;
    }

    /**
     * Generate download token.
     */
    public function generateDownloadToken(): void
    {
        $this->update([
            'download_token' => Str::random(64),
            'download_expires_at' => now()->addDays(3),
            'paid_at' => now(),
            'status' => 'paid',
        ]);
    }

    /**
     * Check if download token is valid.
     */
    public function isDownloadable(): bool
    {
        return $this->status === 'paid'
            && $this->download_token !== null
            && $this->download_count < 2
            && ($this->download_expires_at === null || $this->download_expires_at->isFuture());
    }

    /**
     * Scope: filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Format amount ke Rupiah.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
