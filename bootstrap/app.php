<?php

// use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;
// use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    // Redirects authenticated users from "guest-only" areas (unauthenticated users)
    $middleware->redirectUsersTo('/admin');
    // Redirects guests from "authenticated users-only" areas
    $middleware->redirectGuestsTo('/admin/login');

    $middleware->alias([
      'admin' => IsAdmin::class,
      // These are basically empty versions of the Laravel middlewares,
      // they extend the originals which makes it possible to
      // override/customize the functionality from them
      // that is used in the Laravel application.
      // 'auth' => Authenticate::class,
      // 'guest' => RedirectIfAuthenticated::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
