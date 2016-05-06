<?php

namespace FootStapp\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
  /**
   * The application's global HTTP middleware stack.
   *
   * @var array
   */
  protected $middleware = [
    \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
//    \FootStapp\Http\Middleware\EncryptCookies::class,
//    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
//    \Illuminate\Session\Middleware\StartSession::class,
//    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//    \FootStapp\Http\Middleware\VerifyCsrfToken::class,
    \Barryvdh\Cors\HandleCors::class,
  ];

  /**
   * The application's route middleware.
   *
   * @var array
   */
  protected $routeMiddleware = [
//    'auth' => \FootStapp\Http\Middleware\Authenticate::class,
//    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
//    'guest' => \FootStapp\Http\Middleware\RedirectIfAuthenticated::class,
  ];
}
