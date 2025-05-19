@extends('layouts.admin')

@section('content')
<h2>Edit User</h2>
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
<form action="{{ route('users.update', $user->id) }}" method="POST">
  @csrf
  @method('PATCH') <!-- PATCH = Partial update -->
  <table>
    <tbody>
      <tr>
        <td><label for="firstname">Firstname</label>:</td>
        <td><input type="text" id="firstname" name="firstname" value="{{ old('firstname') ?? $user->firstname }}" required></td>
      </tr>
      <tr>
        <td><label for="lastname">Lastname</label>:</td>
        <td><input type="text" id="lastname" name="lastname" value="{{ old('lastname') ?? $user->lastname }}" required></td>
      </tr>
      <tr>
        <td><label for="email">Email</label>:</td>
        <td><input type="email" id="email" name="email" value="{{ old('email') ?? $user->email }}" required></td>
      </tr>
      <tr>
        <td><label for="password">Password</label>:</td>
        <td><input type="password" id="password" name="password"></td>
      </tr>
      <tr>
        <td><label for="confirm_password">Confirm Password</label>:</td>
        <td><input type="password" id="confirm_password" name="confirm_password"></td>
      </tr>
      <tr>
        <td><label for="email_verified">Email Verified</label>:</td>
        <td><input type="checkbox" id="email_verified" name="email_verified" value="1"{{ $user->email_verified ? ' checked' : '' }}></td>
      </tr>
      <tr>
        <td><label for="is_admin">Is Admin</label>:</td>
        <td><input type="checkbox" id="is_admin" name="is_admin" value="1"{{ $user->is_admin ? ' checked' : '' }}></td>
      </tr>
      <tr>
        <td><label for="created_at">Created</label>:</td>
        <td><span id="created_at">{{ longDateStr($user->created_at) }}</span></td>
      </tr>
      <tr>
        <td><label for="updated_at">Updated</label>:</td>
        <td><span id="updated_at">{{ longDateStr($user->updated_at) }}</span></td>
      </tr>
      <tr>
        <td class="button"><button type="submit" class="link-button">Update User</button></td>
        <td class="button button--right"><a href="{{ route('users.show', $user->id) }}" class="link-button secondary" role="button">Cancel</a></td>
      </tr>
    </tbody>
  </table>
</form>
</section>
@endsection
