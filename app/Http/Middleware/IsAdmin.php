<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin {
  public function handle(Request $request, Closure $next): Response {
    // If user is authenticated but not admin, redirect to home
    if (!auth('admin')->user()?->is_admin) {
      return redirect()->route('home.index')->withErrors(['error' => 'Administrator privileges required.']);
    }

    // Otherwise return the request unaffected
    return $next($request);
  }
}
