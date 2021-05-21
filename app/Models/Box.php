<?php

namespace App\Models;

use App\Casts\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id', 'amount'
    ];

    protected $casts = [
        "amount" => Price::class,
    ];

    public function guest () {
        return $this->belongsTo(Guest::class);
    }

    public function guests () {
        return $this->hasMany(Guest::class);
    }
}
