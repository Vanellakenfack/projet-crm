<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Ajout de cette ligne

class User extends Authenticatable implements JWTSubject
{
    use HasFactory; // Assurez-vous que cette ligne est présente

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey(); // Return the primary key of the user
    }

    public function getJWTCustomClaims()
    {
        return []; // Return any custom claims if needed
    }
}
