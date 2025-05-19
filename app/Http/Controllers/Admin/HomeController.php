<?php

namespace App\Http\Controllers\Admin;

class HomeController extends AdminController {
  public function index() {
    $links = $this->linksAdmin;
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin'
    ];
    return view('admin.index', compact('links', 'breadcrumbs'));
  }
}
