<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ResourceObject;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'last_name', 'dni',
        'phone', 'date_of_birth', 'status',
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $type = 'users';

    public function fields(): array
    {
      return [
        'id' => (string) $this->id,
        'name' => $this->name,
        'last_name'=> $this->last_name,
        'dni' => $this->dni,
        'phone' => $this->phone,
        'email' => $this->email,
        'date_of_birth' => $this->date_of_birth, //Carbon::parse($this->date_of_birth)->isoFormat('YYYY MMMM DD'),
        'created_at' => $this->created_at,//->isoFormat('YYYY MMMM DD')
        'status' => $this->status,
        'role' => ResourceObject::make($this->role),
        'image' => ImageResource::make($this->image),
        'links' => [
            'self' => route('api.v1.'. $this->type .'.show', $this->getRouteKey())
          ],
      ];
    }

    public function username()
    {
        return 'email';
    }

    public function role ()
    {
        return $this->belongsTo(Role::class);
    }

    public function image ()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
