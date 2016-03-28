<?php namespace Syscover\Hotels;

use Illuminate\Support\ServiceProvider;

class SpasServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// include route.php file
		if (!$this->app->routesAreCached())
			require __DIR__ . '/../../routes.php';

		// register views
		$this->loadViewsFrom(__DIR__ . '/../../views', 'spas');

        // register translations
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'spas');

        // register public files
        $this->publishes([
            __DIR__ . '/../../../public' 					=> public_path('/packages/syscover/spas')
        ]);

        // register config files
        $this->publishes([
            __DIR__ . '/../../config/hotels.php' 			=> config_path('spas.php')
        ]);

        // register migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations/' 		=> base_path('/database/migrations'),
            __DIR__ . '/../../database/migrations/updates/' => base_path('/database/migrations/updates'),
        ], 'migrations');

        // register seeds
        $this->publishes([
            __DIR__ . '/../../database/seeds/' 				=> base_path('/database/seeds')
        ], 'seeds');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        //
	}
}