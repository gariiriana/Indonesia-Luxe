<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'image',
        'tour_count',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
