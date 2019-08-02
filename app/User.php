<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\System\Role;
use Log;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isSuperAdmin()
    {
        // 系统初始的第一个用户为超级管理员
        if ($this->email == 'admin@admin.com')
            return true;

        return $this->hasRole('superadministrator');
    }

    public function isForwarder()
    {
        return $this->hasRole('forwarder');
    }

    public function isVendor()
    {
        return $this->hasRole('vendor');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);

    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    public function hasPermission($permission)
    {
        Log::info($permission);
        return $this->hasRole($permission->roles);
    }

}
