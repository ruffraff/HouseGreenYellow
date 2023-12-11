<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Permission",
 *     type="object",
 *     title="Permission",
 *     description="Permission model for handling permissions in the system",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the permission"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the permission"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the permission"
 *     ),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Role"),
 *         description="Roles that have this permission"
 *     )
 * )
 */
class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * I ruoli che possiedono questo permesso.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
