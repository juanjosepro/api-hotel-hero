<?php

namespace App\Models;

use App\Casts\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ImageResource;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'details'];

    public $type = 'categories';

    /* public function getImageAttribute($value)
    {
        return $value ? : url(Storage::url('public/without-image.jpg'));
    } */
    protected $casts = [
        "price" => Price::class,
    ];

    public function fields(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'details' => $this->details,
            'images' => ImageResource::collection($this->images),
            'created_at' => $this->created_at,
            'links' => [
                'self' => route('api.v1.'. $this->type .'.show', $this->getRouteKey())
            ],
        ];
    }

    // public function getRouteKeyName(): string
    // {
    //     return 'name';
    // }

    public function image () {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function images () {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function rooms () {
        //clase1, foreign_key(clase2), foreign_key(clase1)
        return $this->hasMany(Room::class, "category_id", "id");
    }

}
