<?php

namespace FootStapp\Policies\v1;

use FootStapp\Entities\User;

class UserPolicy
{
  public function canSeeAll(User $user)
  {
    foreach ($user->userGroups as $userGroup) {
      if ($userGroup->permissions->contains("name", "users.index")) {
        return true;
      }
    }

    return false;
  }
}
