<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        "room_number", "category", "via", "persons", "name", "last_name", "dni",
        "phone", "entry_date", "departure_date", "origin", "message"
    ];

    public $type = 'reservations';

    public function fields(): array
    {
      return [
        'id' => (string) $this->id,
        'room_number' => $this->room_number,
        'category' => $this->room->category,
        'persons' => $this->persons,
        'name' => $this->name,
        'last_name'=> $this->last_name,
        'dni' => $this->dni,
        'phone' => $this->phone,
        'email' => $this->email,
        'entry_date' => $this->entry_date,
        'departure_date' => $this->departure_date,
        'origin' => $this->origin,
        'message' => $this->message,
        'via' => $this->via,
        'created_at' => $this->created_at,
          'links' => [
            'self' => route('api.v1.'. $this->type .'.show', $this->getRouteKey())
        ],
      ];
    }

    public function room () {
        return $this->belongsTo(Room::class, "room_number", "number");
    }
}
