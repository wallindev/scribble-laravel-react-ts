<?php

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Login (from React)

Route::get('/login', function (Request $request) {
  // echo('Logging in!');
  // var_dump($request);
  return response()->json(['message' => 'Hello, this is the API! =)']);
});
Route::post('/login', function (Request $request) {
  // echo('Logging in!');
  // var_dump($request);
  return response()->json(['message' => 'Hello, this is the API! =)']);
});

// All Articles
Route::get('/articles', function () {
  $articles = Article::all();
  return response()->json($articles);
});

// All users
Route::get('/users', function () {
  $users = User::all();
  return response()->json($users);
});

// One Article
Route::get('/articles/{id}', function (string $id) {
  $article = Article::findOrFail($id);
  return response()->json($article);
})->where('id', '[0-9]+');

// One User
Route::get('/users/{id}', function (string $id) {
  $user = User::findOrFail($id);
  return response()->json($user);
})->where('id', '[0-9]+');
