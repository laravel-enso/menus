<?php

namespace LaravelEnso\MenuManager\app\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'icon', 'link', 'has_children', 'parent_id'];

    public function roles()
    {
        return $this->belongsToMany('LaravelEnso\RoleManager\app\Models\Role')->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo('LaravelEnso\MenuManager\app\Models\Menu');
    }

    public function getRolesListAttribute()
    {
        return $this->roles->pluck('id')->toArray();
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
