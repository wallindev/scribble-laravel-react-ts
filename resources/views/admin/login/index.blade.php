@extends('layouts.admin')

@section('content')
<h2>Log In</h2>
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
<form action="{{ route('auth.login') }}" method="POST">
  @csrf
  @method('POST')
  <table>
    <tbody>
      <tr>
        <td><label for="email">Email</label>:</td>
        <td><input type="email" id="email" name="email" value="{{ old('email') }}" required></td>
      </tr>
      <tr>
        <td><label for="password">Password</label>:</td>
        <td><input type="password" id="password" name="password" required></td>
      </tr>
      <tr>
        <td><label for="remember">Keep login</label>:</td>
        <td><input type="checkbox" id="remember" name="remember" value="1"></td>
      </tr>
      <tr>
        <td class="button"><button type="submit" class="link-button">Log In</button></td>
        <td class="button button--right"><a href="{{ route('home.index') }}" class="link-button secondary" role="button">Cancel</a></td>
      </tr>
    </tbody>
  </table>
</form>
</section>
@endsection
