<?php

namespace FootStapp\Providers;

use Illuminate\Support\ServiceProvider;

class FractalServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
    // TODO Test this one out
    $this->app->bind('\League\Fractal\Manager', function ($app) {
      $fractal = new \League\Fractal\Manager;
      $serializer = new \League\Fractal\Serializer\JsonApiSerializer(env('API_DOMAIN', null));
      $fractal->setSerializer($serializer);

      return $fractal;
    });
  }
}
