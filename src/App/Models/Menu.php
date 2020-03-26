<?php

namespace LaravelEnso\Menus\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaravelEnso\Menus\App\Exceptions\Menu as Exception;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Roles\App\Models\Role;
use LaravelEnso\Tables\App\Traits\TableCache;

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
            throw Exception::hasChildren();
        }

        if ($this->rolesWhereIsDefault()->exists()) {
            throw Exception::usedAsDefault();
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
