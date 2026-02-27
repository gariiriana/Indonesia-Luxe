<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuxePoint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'points', 'type', 'description', 'pointable_id', 'pointable_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pointable()
    {
        return $this->morphTo();
    }
}
