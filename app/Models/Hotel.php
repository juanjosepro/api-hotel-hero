<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Hotel extends Model
{
    use HasFactory;

    protected $table = "hotel";

    protected $fillable = [
        "name", "ruc", "location",
        "levels", "phone", "email", "description", "image", "logo"
    ];

    public $type = "hotel";

    public function fields(): array
    {
      return [
        "id" => (string) $this->id,
        "name" => $this->name,
        "ruc"=> $this->ruc,
        "location" => $this->location,
        "levels" => $this->levels,
        "phone" => $this->phone,
        "email" => $this->email,
        "description" => $this->description,
        "image" => url(Storage::url($this->image)),
        "logo" => url(Storage::url($this->logo)),
        "links" => [
          "self" => route("api.v1.". $this->type .".index", $this->getRouteKey())
        ],
      ];
    }
}

