<?php

namespace App\Http\Controllers;

class HomeController extends Controller {
  public function index() {
    $path = public_path('frontend/index.html');
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
  }
}
