<?php

namespace Admin\Policies;

use App\Models\Access\User;
use App\Models\Access\Role;
use Admin\Http\Sections\Access\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class RolesSectionModelPolicy
 * @package Admin\Policies
 */
class RolesSectionModelPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Roles $section
     * @param Role $item
     *
     * @return bool
     */
    public function display(User $user, Roles $section, Role $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param Roles $section
     * @param Role $item
     * @return bool
     */
    public function create(User $user, Roles $section, Role $item)
    {
        return $user->isAdmin();
    }

    /**
     * @param User $user
     * @param Roles $section
     * @param Role $item
     * @return bool
     */
    public function edit(User $user, Roles $section, Role $item)
    {
        return $user->isAdmin();
    }

    /**
     * @param User $user
     * @param Roles $section
     * @param Role $item
     * @return bool
     */
    public function delete(User $user, Roles $section, Role $item)
    {
        return $user->isAdmin();
    }
}
