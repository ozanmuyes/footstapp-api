<?php

namespace FootStapp\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    app()->bind('\FootStapp\Repositories\UserRepository', '\FootStapp\Repositories\UserRepositoryEloquent');
    app()->bind('\FootStapp\Repositories\UserGroupRepository', '\FootStapp\Repositories\UserGroupRepositoryEloquent');
    app()->bind('\FootStapp\Repositories\PermissionRepository', '\FootStapp\Repositories\PermissionRepositoryEloquent');
  }
}