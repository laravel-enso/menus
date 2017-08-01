<?php

namespace LaravelEnso\MenuManager\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\DbSyncMigrations\app\Traits\DbSyncMigrations;
use LaravelEnso\Helpers\Traits\FormattedTimestamps;
use LaravelEnso\RoleManager\app\Models\Role;

class Menu extends Model
{
    use FormattedTimestamps, DbSyncMigrations;

    protected $fillable = ['name', 'icon', 'link', 'has_children', 'parent_id'];

    protected $attributes = ['order' => 999, 'has_children' => false];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class);
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
