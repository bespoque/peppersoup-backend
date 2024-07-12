<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class Permission extends Model implements Auditable
{

    use HasFactory;
    use AuditableTrait;

    public $fillable = [
        'name',
        'role_id',
        'user_roles_id'
    ];

    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class,"role_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserRoles::class,"user_roles_id");
    }


}
