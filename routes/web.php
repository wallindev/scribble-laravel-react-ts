<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use Illuminate\Support\Facades\Route;

// Start/Root Page, this is going to serve the React SPA (this is public, no restrictions)
Route::resource('/', HomeController::class)->only('index')->name('index', 'home.index');
// Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Everything from "/admin" path and beyond
Route::prefix('admin')->group(function () {
  // Unauthenticated users ("guests" in the "admin" guard) have access
  Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
  });

  // Authenticated users that are NOT admin have access ("users" in the "admin" guard with is_admin=false)
  Route::middleware('auth:admin')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
  });

  // Authenticated users that ARE admin have access ("users" in the "admin" guard with is_admin=true)
  Route::middleware(['auth:admin', 'admin'])->group(function () {
    // Admin Start Page
    Route::resource('/', AdminHomeController::class)->only('index')->name('index', 'admin.index');
    // Route::get('/', [AdminHomeController::class, 'index'])->name('admin.index');

    /*
    * Users
    */
    Route::get('users/new', [UserController::class, 'create'])->name('users.create');
    Route::resource('users', UserController::class);

    /*
    * Articles
    */
    Route::get('articles/new', [ArticleController::class, 'create'])->name('articles.create');
    Route::resource('articles', ArticleController::class)->except('create');
  });

  // Catch-all for admin, to avoid "HTTP 404 Not Found" generic error page
  Route::any('{any}', function () {
    return redirect()->route('admin.index')->withErrors(['error' => 'Page does not exist.']);
  })->where('any', '.*');
});

// Catch-all for root, to avoid "HTTP 404 Not Found" generic error page
// Route::any('{any}', function () {
//   return redirect()->route('home.index')->withErrors(['error' => 'Page does not exist.']);
// })->where('any', '.*');
