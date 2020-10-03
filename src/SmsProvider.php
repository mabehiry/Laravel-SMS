<?php
namespace mabehery\sms;

use Illuminate\Support\ServiceProvider;
use mabehery\sms\Sms;
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
     if(!file_exists(base_path('config').'/sms.php'))
     {
      $this->publishes([
        __DIR__.'/config' => base_path('config'),
      ]);
     }

      $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       
            $this->app['Sms'] = $this->app->singleton('Sms',function($app)
            {
                return new Sms();
            });

    }
}
