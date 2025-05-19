<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler {
  protected $dontReport = [];

  protected $dontFlash = [
    'password',
    'confirm_password',
  ];

  public function register(): void {
    $this->renderable(function (TokenMismatchException $e, $request) {
      return redirect()->guest(route('auth.login'))
        ->with('message', 'Your session has expired. Please login again.');
    });
  }
}