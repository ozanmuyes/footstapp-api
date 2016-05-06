<?php

namespace FootStapp\Policies\v1;

use FootStapp\Entities\User;

class PermissionPolicy
{
  public function canSeeAll(User $user)
  {
    foreach ($user->userGroups as $userGroup) {
      if ($userGroup->permissions->contains("name", "permissions.index")) {
        return true;
      }
    }

    return false;
  }
}
