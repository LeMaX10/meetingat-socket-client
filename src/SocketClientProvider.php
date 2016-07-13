<?php
namespace LeMaX10\MeetingatSocketClient;

use Log;
use Illuminate\Support\ServiceProvider;

class SocketClientProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

        $this->publishes(array(__DIR__ . '/config/config.php' => config_path('SocketClient.php')), 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('SocketClient', function ($app) {
            $user_config = $app['config']['SocketClient'] ?: $app['config']['SocketClient::config'];

            // Make sure we don't crash when we did not publish the config file
            if (is_null($user_config)) {
                $user_config = [];
            }

            $client = new MethodRouter($user_config);
            return $client;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('SocketClient');
    }
}