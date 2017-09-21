<?php namespace Syscover\ShoppingCart;

use Illuminate\Support\ServiceProvider;

class UpsServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        // register routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        // register config files
        $this->publishes([
            __DIR__ . '/../../config/pulsar-ups.php' => config_path('pulsar-ups.php'),
        ]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}
}