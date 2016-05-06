<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $users = [
      [
        "first_name" => "Ozan",
        "middle_name" => null,
        "last_name" => "Müyesseroğlu",
        "email" => "ozi5169@gmail.com",
        "password" => "ozi5169@gmail.com",
        "user_groups" => [1]
      ],
      [
        "first_name" => "Ertem",
        "middle_name" => null,
        "last_name" => "Eğilmez",
        "email" => "e.egilmez@gmail.com",
        "password" => "e.egilmez@gmail.com",
        "user_groups" => [3]
      ],
      [
        "first_name" => "Münir",
        "middle_name" => null,
        "last_name" => "Özkul",
        "email" => "m.ozkul@gmail.com",
        "password" => "m.ozkul@gmail.com",
        "user_groups" => [4]
      ],
      [
        "first_name" => "Adile",
        "middle_name" => null,
        "last_name" => "Naşit",
        "email" => "a.nasit@gmail.com",
        "password" => "a.nasit@gmail.com",
        "user_groups" => [4]
      ],
      [
        "first_name" => "Tarık",
        "middle_name" => null,
        "last_name" => "Akan",
        "email" => "t.akan@gmail.com",
        "password" => "t.akan@gmail.com",
        "user_groups" => [5]
      ]
    ];

    // TODO Use repository where appropriate
    foreach ($users as $user) {
      $newUser = \FootStapp\Entities\User::create([
        "first_name" => $user["first_name"],
        "middle_name" => @$user["middle_name"],
        "last_name" => $user["last_name"],
        "email" => $user["email"],
        "password" => Hash::make($user["password"])
      ]);

      if (@$user["user_groups"] !== null && count($user["user_groups"]) > 0) {
        foreach ($user["user_groups"] as $userGroupId) {
          $newUser->userGroups()->attach($userGroupId);
        }
      }
    }
  }
}
