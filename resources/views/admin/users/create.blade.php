@extends('layouts.admin')

@section('content')
<h2>Create User</h2>
@if ($errors->any())
<div class="user-msg text-danger bg-dark">
  <ul>
  @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
  @endforeach
  </ul>
</div>
@endif
<section>
<form action="{{ route('users.store') }}" method="POST">
  @csrf
  @method('POST')
  <table>
    <tbody>
      <tr>
        <td><label for="firstname">Firstname</label>:</td>
        <td><input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" required></td>
      </tr>
      <tr>
        <td><label for="lastname">Lastname</label>:</td>
        <td><input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required></td>
      </tr>
      <tr>
        <td><label for="email">Email</label>:</td>
        <td><input type="email" id="email" name="email" value="{{ old('email') }}" required></td>
      </tr>
      <tr>
        <td><label for="password">Password</label>:</td>
        <td><input type="password" id="password" name="password" required></td>
      </tr>
      <tr>
        <td><label for="confirm_password">Confirm Password</label>:</td>
        <td><input type="password" id="confirm_password" name="confirm_password" required></td>
      </tr>
      <tr>
        <td><label for="email_verified">Email Verified</label>:</td>
        <td><input type="checkbox" id="email_verified" name="email_verified" value="1" checked></td>
      </tr>
      <tr>
        <td><label for="is_admin">Is Admin</label>:</td>
        <td><input type="checkbox" id="is_admin" name="is_admin" value="1"></td>
      </tr>
      <tr>
        <td class="button"><button type="submit" class="link-button">Save User</button></td>
        <td class="button button--right"><a href="{{ route('users.index') }}" class="link-button secondary" role="button">Cancel</a></td>
      </tr>
    </tbody>
  </table>
</form>
</section>
@endsection
