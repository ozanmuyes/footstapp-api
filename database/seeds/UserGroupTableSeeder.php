<?php

use Illuminate\Database\Seeder;

class UserGroupTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $userGroups = [
      [
        "name" => "developer",
        "title" => "Developer",
        "permissions" => [1, 2, 3, 4, 5, 6]
      ],
      [
        "name" => "tester",
        "title" => "Tester",
        "permissions" => [1, 2, 3, 4, 5]
      ],
      [
        "name" => "administrator",
        "title" => "Administrator",
        "permissions" => [2, 3, 4, 5]
      ],
      [
        "name" => "moderator",
        "title" => "Moderator",
        "permissions" => [2]
      ],
      [
        "name" => "user",
        "title" => "User",
        "permissions" => [5]
      ],
      [
        "name" => "visitor",
        "title" => "Visitor",
        "permissions" => [5]
      ]
    ];

     // TODO Use repository where appropriate
    foreach ($userGroups as $userGroup) {
      $newUserGroup = \FootStapp\Entities\UserGroup::create([
        "name" => $userGroup["name"],
        "title" => @$userGroup["title"]
      ]);

      if (@$userGroup["permissions"] !== null && count($userGroup["permissions"]) > 0) {
        foreach ($userGroup["permissions"] as $permissionId) {
          $newUserGroup->permissions()->attach($permissionId);
        }
      }
    }
  }
}
