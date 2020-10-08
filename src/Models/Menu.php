<?php

namespace LaravelEnso\Menus\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaravelEnso\Menus\Exceptions\Menu as Exception;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\Tables\Traits\TableCache;

class Menu extends Model
{
    use HasFactory, TableCache;

    protected $guarded = ['id'];

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

    public function scopeIsParent(Builder $query)
    {
        return $query->whereHasChildren(true);
    }

    public function scopeIsNotParent(Builder $query)
    {
        return $query->whereHasChildren(false);
    }
}
