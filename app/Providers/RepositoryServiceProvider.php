<?php

namespace App\Providers;

use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
  /**
   * Bind Repository Interfaces and Repositories.
   *
   * @return void
   */
  public function register(): void {
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
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
