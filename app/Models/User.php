<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model for handling users in the system",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the user"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the user"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the user"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the email was verified"
 *     ),
 *     @OA\Property(
 *         property="bookings",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Booking"),
 *         description="List of bookings made by the user"
 *     ),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Role"),
 *         description="Roles assigned to the user"
 *     )
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function isOwner()
    {
        return $this->roles()->where('name', 'owner')->exists();
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

}
