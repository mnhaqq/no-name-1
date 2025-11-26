<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /** @use HasFactory<\Database\Factories\RegionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'capital',
        'longitude',
        'latitude',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
