<?php

namespace LaravelEnso\MenuManager\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\Multitenancy\app\Traits\SystemConnection;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Menu extends Model
{
    use SystemConnection;

    protected $fillable = [
        'name', 'parent_id', 'permission_id', 'icon', 'order_index', 'has_children',
    ];

    protected $casts = [
        'has_children' => 'boolean',
        'parent_id' => 'integer',
        'permission_id' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function rolesWhereIsDefault()
    {
        return $this->hasMany(Role::class);
    }

    public function delete()
    {
        if ($this->children()->count()) {
            throw new ConflictHttpException(
                __('The menu cannot be deleted because it has children')
            );
        }

        if ($this->rolesWhereIsDefault()->count()) {
            throw new ConflictHttpException(
                __('The menu cannot be deleted because it is set as default for one or more roles')
            );
        }

        parent::delete();
    }

    public function scopeIsParent($query)
    {
        return $query->whereHasChildren(true);
    }

    public function scopeIsNotParent($query)
    {
        return $query->whereHasChildren(false);
    }
}
