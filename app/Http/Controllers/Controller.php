<?php

namespace App\Http\Controllers;

abstract class Controller
{
  // Shared breadcrumbs for the whole website
  protected $linksHome = ['admin' => 'Admin'];
  protected $linksAdmin = [
    '/admin/users' => 'Users',
    '/admin/articles' => 'Articles',
  ];
  protected $breadcrumbs = ['/' => 'Home'];
}
