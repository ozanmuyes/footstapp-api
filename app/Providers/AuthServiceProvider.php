<?php

namespace FootStapp\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
//    'FootStapp\Model' => 'FootStapp\Policies\ModelPolicy',
    \FootStapp\Entities\User::class => \FootStapp\Policies\v1\UserPolicy::class,
    \FootStapp\Entities\Permission::class => \FootStapp\Policies\v1\PermissionPolicy::class,
  ];

  /**
   * Register any application authentication / authorization services.
   *
   * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
   * @return void
   */
  public function boot(GateContract $gate)
  {
    parent::registerPolicies($gate);

    //
  }
}
