<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated as RedirectIfAuthenticatedFramework;
use Illuminate\Support\Facades\Route;

class RedirectIfAuthenticated extends RedirectIfAuthenticatedFramework {
  /**
   * Get the default URI the user should be redirected to when they are authenticated.
   */
  protected function defaultRedirectUri(): string {
    $routeName = config('auth.redirect_after_login', 'home.index');
    if (Route::has($routeName))
      return route($routeName);

    foreach (['dashboard', 'home'] as $uri) {
      if (Route::has($uri)) {
        return route($uri);
      }
    }

    $routes = Route::getRoutes()->get('GET');

    foreach (['dashboard', 'home'] as $uri) {
      if (isset($routes[$uri])) {
        return '/' . $uri;
      }
    }

    return '/';
  }
}
