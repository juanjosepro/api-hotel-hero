<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ["name", "description"];

    public $type = 'roles';

    public function fields(): array
    {
      return [
        'id' => (string) $this->id,
        'name' => $this->name,
        'description' => $this->description,
        'created_at' => $this->created_at,
        'links' => [
          'self' => route('api.v1.'. $this->type .'.show', $this->getRouteKey())
        ],
      ];
    }
}
