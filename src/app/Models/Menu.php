<?php

namespace LaravelEnso\Menus\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaravelEnso\Permissions\app\Models\Permission;
use LaravelEnso\Roles\app\Models\Role;
use LaravelEnso\Tables\app\Traits\TableCache;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Menu extends Model
{
    use TableCache;

    protected $fillable = [
        'name', 'parent_id', 'permission_id', 'icon', 'order_index', 'has_children',
    ];

    protected $casts = [
        'has_children' => 'boolean', 'parent_id' => 'integer', 'permission_id' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function rolesWhereIsDefault()
    {
        return $this->hasMany(Role::class);
    }

    public function getComputedIconAttribute()
    {
        return Str::contains($this->icon, ' ')
            ? explode(' ', $this->icon)
            : $this->icon;
    }

    public function delete()
    {
        if ($this->children()->exists()) {
            throw new ConflictHttpException(
                __('The menu cannot be deleted because it has children')
            );
        }

        if ($this->rolesWhereIsDefault()->exists()) {
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
