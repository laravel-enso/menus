<?php

namespace LaravelEnso\MenuManager\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\DbSyncMigrations\app\Traits\DbSyncMigrations;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\RoleManager\app\Models\Role;

class Menu extends Model
{
    use DbSyncMigrations;

    protected $fillable = ['name', 'icon', 'order', 'link', 'has_children', 'parent_id'];

    protected $attributes = ['order' => 999, 'has_children' => false];

    protected $casts = ['has_children' => 'boolean'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'link', 'name');
    }

    public function getRoleListAttribute()
    {
        return $this->roles()->pluck('id');
    }

    public function getChildrenListAttribute()
    {
        return self::whereParentId($this->id)->pluck('id');
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
