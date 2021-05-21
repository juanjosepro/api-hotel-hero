<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ResourceObject;
use App\Http\Resources\ResourceObject2;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'number', 'level', 'location', 'status'
    ];

    public $type = 'rooms';

    public function fields(): array
    {
        return [
            'id' => (string) $this->id,
            'number' => $this->number,
            'level' => $this->level,
            'status' => $this->status,
            'location' => $this->location,
            'category' => ResourceObject::make($this->category),
            'created_at' => $this->created_at,
            'links' => [
                'self' => route('api.v1.'. $this->type .'.show', $this->getRouteKey())
            ],
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'number';
    }

    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    public function guest () {
        return $this->belongsTo(Guest::class);
    }

    public function guests () {
        return $this->hasMany(Guest::class);
    }
}
