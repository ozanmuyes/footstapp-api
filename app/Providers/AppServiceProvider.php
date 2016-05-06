<?php

namespace FootStapp\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    /**
     * @var \Dingo\Api\Exception\Handler $dingoExceptionHandler
     */
    $dingoExceptionHandler = app('Dingo\Api\Exception\Handler');

    /**
     * @var \FootStapp\Exceptions\Handler $FootStappExceptionHandler
     */
    $FootStappExceptionHandler = app('FootStapp\Exceptions\Handler');

//    $dingoExceptionHandler->register(function (Exception $exception) use ($FootStappExceptionHandler) {
//      return $FootStappExceptionHandler->handle($exception);
//    });
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }
}
