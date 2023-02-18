<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

use URL;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// Set pagination to bootstrap
		Paginator::useBootstrap();

		// Use https when on peoduction
		if(config('app.env') === 'production' || config('app.env') === 'staging') {
			URL::forceScheme('https');
		}
	}
}
