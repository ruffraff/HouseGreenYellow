<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Role",
 *     type="object",
 *     title="Role",
 *     description="Role model for handling user roles in the system",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the role"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the role"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the role"
 *     ),
 *     @OA\Property(
 *         property="users",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/User"),
 *         description="Users who have this role"
 *     ),
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Permission"),
 *         description="Permissions associated with this role"
 *     )
 * )
 */
class Role extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Gli utenti che possiedono questo ruolo.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    /**
     * I permessi associati a questo ruolo.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
