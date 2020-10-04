<?php
namespace Mabehiry\Sms;

use Illuminate\Support\ServiceProvider;
use Mabehiry\Sms\Sms;
use Config;
class SmsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
          __DIR__ . '/config/sms.php' => config_path('sms.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sms');
        $this->publishes([
          __DIR__ . '/../resources/views' => resource_path('views/vendor/sms'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       
          $this->app['SMS'] = $this->app->singleton('SMS',function($app)
          {
              return new SMS();
          });

          //$this->app->make('Mabehiry\Sms\Sms');

          app()->bind('Sms', function () {
            return new \Mabehiry\Sms;
          });

          $this->mergeConfigFrom(
            __DIR__ . '/config/sms.php',
            'sms'
          );

    }
}
