<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $permissions = [
      [
        "name" => "users.index",
        "title" => "See All Users",
        "description" => "See all users' all information"
      ],
      [
        "name" => "users.index[first_name, last_name, email]",
        "title" => "See All Users",
        "description" => "See all users' first_name, last_name and email"
      ],
      [
        "name" => "users.view",
        "title" => "See Individual User",
        "description" => "See any users' all information (except hidden ones)"
      ],
      [
        "name" => "users.view[-email]",
        "title" => "See Individual User",
        "description" => "See any users' all information except email (and hidden ones)"
      ],
      [
        "name" => "users.view.self",
        "title" => "See Self User",
        "description" => "See self (users') all information (except hidden ones)"
      ],

      [
        "name" => "permissions.index",
        "title" => "See All Permissions",
        "description" => "See all permissions"
      ]
    ];

    foreach ($permissions as $permission) {
      \FootStapp\Entities\Permission::create([
        "name" => $permission["name"],
        "title" => @$permission["title"],
        "description" => @$permission["description"]
      ]);
    }
  }
}
