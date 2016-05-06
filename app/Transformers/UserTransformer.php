<?php

namespace FootStapp\Transformers;

use FootStapp\Entities\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
  /**
   * List of resources possible to include.
   *
   * @var array $availableIncludes
   */
  protected $availableIncludes = [
    "userGroups"
  ];

  /**
   * List of resources to automatically include.
   *
   * @var array $defaultIncludes
   */
  protected $defaultIncludes = [
    "userGroups"
  ];

  /**
   * Turn this item object into a generic array.
   *
   * @param User $user
   * @return array
   */
  public function transform(User $user)
  {
    return [
      "id" => strval($user->id),
      "first-name" => $user->first_name,
      "middle-name" => $user->middle_name,
      "last-name" => $user->last_name,
      "email" => $user->email,
      "created-at" => $user->created_at->toIso8601String(),
      "updated-at" => $user->updated_at->toIso8601String(),
    ];
  }

  /**
   * Include user group(s) for individual user.
   *
   * @param \FootStapp\Entities\User $user
   * @return \League\Fractal\Resource\Collection
   */
  public function includeUserGroups(User $user)
  {
    return $this->collection($user->userGroups, new UserGroupTransformer, "user-groups");
  }
}
