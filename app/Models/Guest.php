<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ResourceObject;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number', 'name', 'last_name', 'dni', 'phone', 'email', 'persons',
        'entry_date', 'departure_date', 'status', 'message', 'origin', 'via'
    ];

    public $type = 'guests';

    public function fields(): array
    {
        return [
            'id' => (string) $this->id,
            'room_number' => $this->room_number,
            'name' => $this->name,
            'last_name'=> $this->last_name,
            'dni' => $this->dni,
            'phone' => $this->phone,
            'email' => $this->email,
            'message' => $this->message,
            'origin' => $this->origin,
            'persons' => $this->persons,
            'status' => $this->status,
            'entry_date' => $this->entry_date,
            'via' => $this->via,
            'departure_date' => $this->departure_date, //Carbon::parse($this->date_of_birth)->isoFormat('YYYY MMMM DD'),
            'room' => ResourceObject::make($this->room),
            'links' => [
                'self' => route('api.v1.'. $this->type .'.show', $this->getRouteKey())
            ],
        ];
    }

    public function boxes () {
        return $this->hasMany(Box::class);
    }

    public function box () {
        //clase1, foreign_key(clase2), foreign_key(clase1)
        return $this->belongsTo(Box::class, "guest_id", "id");
    }

    public function room () {
        //clase1, foreign_key(clase2), foreign_key(clase1)
        return $this->belongsTo(Room::class, "room_number", "number");
    }
}
