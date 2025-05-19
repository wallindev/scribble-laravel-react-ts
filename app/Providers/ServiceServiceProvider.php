<?php

namespace App\Providers;

use App\Interfaces\ArticleServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Services\ArticleService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider {
  /**
   * Bind Service Interfaces and Services.
   *
   * @return void
   */
  public function register(): void {
    $this->app->bind(UserServiceInterface::class, UserService::class);
    $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot(): void {
    //
  }
}
