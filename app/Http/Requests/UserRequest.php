<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
  public function rules() {
    $userId = $this->route('id') ?? null;
    $isUpdate = !!$userId;
    $parameters = $this->all();
    $password = $parameters['password'];
    $confirm_password = $parameters['confirm_password'];
    $email_rule = 'required|string|email|max:255|unique:users';
    $isUpdate && $email_rule .= ",email,$userId";
    $pass_regex = '/^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*[0-9]).+$/';
    $pass_rule = "required|string|min:6|regex:$pass_regex|confirmed:confirm_password";
    $conf_pass_rule = "required|string|min:6|regex:$pass_regex";

    $rules_arr = [
      'firstname' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      'email' => $email_rule,
      'email_verified' => 'nullable|string:1',
      'is_admin' => 'nullable|string:1',
    ];

    $password && $rules_arr = [...$rules_arr, 'password' => $pass_rule];
    $confirm_password && $rules_arr = [...$rules_arr, 'confirm_password' => $conf_pass_rule];

    return $rules_arr;
  }

  public function authorize() {
    return true; // You can implement authorization logic here
  }

  public function attributes() {
    return [
      'firstname' => 'First Name',
      'lastname' => 'Last Name',
      'email' => 'Email Address',
      'password' => 'Password',
      'confirm_password' => 'Confirm Password',
      'email_verified' => 'Email Verified',
      'is_admin' => 'Is Admin',
    ];
  }

  public function messages()
  {
    $pass_regex_message = 'The :attribute must contain at least one lowercase and one uppercase letter, and one number.';
    return [
      'password.regex' => $pass_regex_message,
      'password.confirmed' => 'The :attribute and Confirm :attribute fields must match.',
      'confirm_password.regex' => $pass_regex_message,
    ];
  }
}
