<?php

namespace FootStapp\Transformers;

use FootStapp\Entities\UserGroup;
use League\Fractal\TransformerAbstract;

class UserGroupTransformer extends TransformerAbstract
{
  /**
   * List of resources possible to include.
   *
   * @var array
   */
  protected $availableIncludes = [
    "users",
    "permissions"
  ];

  /**
   * List of resources to automatically include.
   *
   * @var array $defaultIncludes
   */
  protected $defaultIncludes = [
    "permissions"
  ];

  /**
   * Turn this item object into a generic array.
   *
   * @param \FootStapp\Entities\UserGroup $userGroup
   * @return array
   */
  public function transform(UserGroup $userGroup)
  {
    return [
      "id" => strval($userGroup->id),
      "name" => $userGroup->name,
      "title" => $userGroup->title,
      "created-at" => $userGroup->created_at->toIso8601String(),
      "updated-at" => $userGroup->updated_at->toIso8601String(),
    ];
  }

  /**
   * Include user(s) for individual user group.
   *
   * @param \FootStapp\Entities\UserGroup $userGroup
   * @return \League\Fractal\Resource\Collection
   */
  public function includeUsers(UserGroup $userGroup)
  {
    return $this->collection($userGroup->users, new UserTransformer, "users");
  }

  /**
   * Include permission(s) for individual user group.
   *
   * @param \FootStapp\Entities\UserGroup $userGroup
   * @return \League\Fractal\Resource\Collection
   */
  public function includePermissions(UserGroup $userGroup)
  {
    return $this->collection($userGroup->permissions, new PermissionTransformer, "permissions");
  }
}
