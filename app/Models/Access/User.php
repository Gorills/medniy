<?php

namespace App\Models\Access;

use Illuminate\{
    Foundation\Auth\User as Authenticatable, Notifications\Notifiable
};
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * Class User
 * @package App\Models\Access
 */
class User extends Authenticatable
{
    use Notifiable,
        EntrustUserTrait;

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

    /**
     * Bcrypt password
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Checks if user is admin
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Checks if user is content-manager
     * @return bool
     */
    public function isContent()
    {
        return $this->hasRole('content');
    }
}
