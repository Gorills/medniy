<?php

namespace Admin\Policies;

use App\Models\Access\User;
use App\Models\Access\Permission;
use Admin\Http\Sections\Access\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PermissionsSectionModelPolicy
 * @package Admin\Policies
 */
class PermissionsSectionModelPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Permissions $section
     * @param Permission $item
     *
     * @return bool
     */
    public function display(User $user, Permissions $section, Permission $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param Permissions $section
     * @param Permission $item
     * @return bool
     */
    public function create(User $user, Permissions $section, Permission $item)
    {
        return $user->isAdmin();
    }

    /**
     * @param User $user
     * @param Permissions $section
     * @param Permission $item
     * @return bool
     */
    public function edit(User $user, Permissions $section, Permission $item)
    {
        return $user->isAdmin();
    }

    /**
     * @param User $user
     * @param Permissions $section
     * @param Permission $item
     * @return bool
     */
    public function delete(User $user, Permissions $section, Permission $item)
    {
        return $user->isAdmin();
    }
}
