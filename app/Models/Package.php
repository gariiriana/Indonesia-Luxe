<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'vendor_id',
        'category_id',
        'destination_id',
        'description',
        'duration',
        'original_price',
        'discounted_price',
        'image',
        'gallery',
        'inclusions',
        'itinerary',
        'rating',
        'review_count',
        'status',
        'views',
    ];

    protected $casts = [
        'gallery' => 'array',
        'inclusions' => 'array',
        'itinerary' => 'array',
        'original_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'rating' => 'float',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getDiscountPercentageAttribute(): int
    {
        if ($this->original_price == 0)
            return 0;
        return round((($this->original_price - $this->discounted_price) / $this->original_price) * 100);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->discounted_price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->original_price, 0, ',', '.');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('review_count', 'desc');
    }
}
