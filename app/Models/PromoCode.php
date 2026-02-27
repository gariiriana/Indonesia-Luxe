<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_price',
        'label',
        'category',
        'promo_group',
        'period',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Calculate discount amount for given subtotal
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percent') {
            return round($subtotal * $this->discount_value / 100);
        }
        return min($this->discount_value, $subtotal);
    }

    /**
     * Validate promo for given subtotal and category
     */
    public function validate(float $subtotal, ?string $tourCategory = null): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'error' => 'Kode promo tidak aktif.'];
        }
        if ($subtotal < $this->min_price) {
            return ['valid' => false, 'error' => "Minimum pembelian Rp " . number_format($this->min_price, 0, ',', '.') . " untuk kode ini."];
        }
        if ($this->category && $tourCategory && $this->category !== $tourCategory) {
            return ['valid' => false, 'error' => "Kode ini hanya berlaku untuk kategori \"{$this->category}\"."];
        }
        return ['valid' => true];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
