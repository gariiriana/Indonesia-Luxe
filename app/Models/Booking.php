<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'package_id',
        'travel_date',
        'travelers',
        'total_amount',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            $booking->booking_code = 'IL' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="badge badge-warning">Menunggu</span>',
            'paid' => '<span class="badge badge-info">Dibayar</span>',
            'confirmed' => '<span class="badge badge-success">Dikonfirmasi</span>',
            'completed' => '<span class="badge badge-primary">Selesai</span>',
            'cancelled' => '<span class="badge badge-danger">Dibatalkan</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }
}
