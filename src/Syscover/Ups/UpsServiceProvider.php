<?php namespace Syscover\Ups;

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
        $this->registerRate();
        $this->registerTracking();
	}

    /**
     * Register the Rate class.
     *
     * @return void
     */
    protected function registerRate()
    {
        $this->app->singleton('ups.rate', function () {
            return new Rate(
                config('pulsar-ups.user'),
                config('pulsar-ups.password'),
                config('pulsar-ups.access_key')
            );
        });
    }

    protected function registerTracking()
    {
        $this->app->singleton('ups.tracking', function () {
            return new Tracking(
                config('pulsar-ups.user'),
                config('pulsar-ups.password'),
                config('pulsar-ups.access_key')
            );
        });
    }
}