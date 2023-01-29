<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function show(User $user, User $user2)
    {
      return ($user->id_user == $user2->id_user || $user->is_admin);
    }

    public function showshoppingcart(User $user, User $user2)
    {
      return !($user2->is_admin);
    }

    public function showwishlist(User $user, User $user2)
    {
      return !($user2->is_admin);
    }

    public function management(User $user , User $user2)
    {
        return ($user2->is_admin);
    }

}
