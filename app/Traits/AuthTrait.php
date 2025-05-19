<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait LogoutTrait
{
  public function logout(Request $request)
  {
    auth('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
  }
}
