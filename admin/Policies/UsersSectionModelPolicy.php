<?php

namespace Admin\Policies;

use App\Models\Access\User;
use Admin\Http\Sections\Access\Users;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UsersSectionModelPolicy
 * @package Admin\Policies
 */
class UsersSectionModelPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     *
     * @return bool
     */
    public function display(User $user, Users $section, User $item)
    {
        return true;
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     * @return bool
     */
    public function create(User $user, Users $section, User $item)
    {
        return $user->isAdmin();
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     * @return bool
     */
    public function edit(User $user, Users $section, User $item)
    {
        if ($user->isAdmin()) {
            return true;
        } elseif ($user->isContent() && $item->isContent()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Users $section
     * @param User $item
     * @return bool
     */
    public function delete(User $user, Users $section, User $item)
    {
        if ($user->isAdmin()) {
            return true;
        } elseif ($user->isContent() && $item->isContent()) {
            return true;
        }
    }
}
