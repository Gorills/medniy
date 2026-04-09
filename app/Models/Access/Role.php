<?php

namespace App\Models\Access;

use Zizaco\Entrust\EntrustRole;

/**
 * Class Role
 * @package App\Models\Access
 */
class Role extends EntrustRole
{
    protected $fillable = ['name', 'email'];
    //
}
