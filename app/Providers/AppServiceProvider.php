<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
  /**
   * Register any application services.
   */
public function register(): void {
  // Register Service Providers
  $this->app->register(RepositoryServiceProvider::class);
  // $this->app->register(ServiceServiceProvider::class);
}

  /**
   * Bootstrap any application services.
   */
  public function boot(): void {
    Route::pattern('id', '[0-9]+');
  }
}
