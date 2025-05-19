<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends AdminController {
  protected $request;

  public function __construct(Request $request) {
    $this->request = $request;
  }

  private function logoutAdmin(): void {
    auth('admin')->logout();
    $this->request->session()->invalidate();
    $this->request->session()->regenerateToken();
  }

  public function index() {
    $title = 'Log In';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/login' => 'Log In'
    ];
    return view('admin.login.index', compact('title', 'breadcrumbs'));
  }

  public function login(): RedirectResponse {
    $credentials = $this->request->only('email', 'password');

    if (!auth('admin')->attempt($credentials, $this->request->filled('remember'))) {
      return back()->withErrors(['email' => 'Wrong email or password.'])->onlyInput('email');
    }

    // Use regenerate() or regenerateToken()?
    // $this->request->session()->regenerateToken();
    $this->request->session()->regenerate();

    $intended = session('url.intended');
    if (!$intended || !str_starts_with($intended, url('/admin'))) {
      $intended = route('admin.index');
    }
    return redirect()->to($intended);
    // return redirect()->intended(route('admin.index'));
  }

  public function logout(): RedirectResponse {
    $this->logoutAdmin();
    return redirect()->route('auth.index');
  }
}
