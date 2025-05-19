<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest {
  public function rules() {
    $rules_arr = [
      'title' => 'required|string|max:255',
      'content' => 'required|string|max:65535',
      'user_id' => 'required|integer|min:0|exists:users,id',
    ];

    return $rules_arr;
  }

  public function authorize() {
    return true; // You can implement authorization logic here
  }

  public function attributes() {
    return [
      'title' => 'Title',
      'content' => 'Content',
    ];
  }
}
