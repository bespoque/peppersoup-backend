<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Role extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    public $fillable = [
        'name',
        'title'
    ];

    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }

    public function permission(): HasMany
    {
        return $this->hasMany(Permission::class);
    }


}
