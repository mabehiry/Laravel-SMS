<?php
namespace Mabehiry\Sms;

use Illuminate\Support\ServiceProvider;

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
        __DIR__ . '/../config/sms.php' => config_path('sms.php'),
        __DIR__ . '/../resources/views' => resource_path('views/vendor/sms'),
        ]);
        
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sms');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
      }
      
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->mergeConfigFrom(
        __DIR__ . '/../config/sms.php',
        'sms'
      );
      
      //$this->app->make('Mabehiry\Sms\Http\Controllers\SmsController');
        
      /*
          $this->app['SMS'] = $this->app->singleton('SMS',function($app)
          {
              return new SMS();
          });


          app()->bind('Sms', function () {
            return new \Mabehiry\Sms;
          });
        */
    }
}
