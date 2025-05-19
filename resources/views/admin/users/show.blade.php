@extends('layouts.admin')

@section('content')
<h2>User Details</h2>
@if (session('success'))
<div class="user-msg text-success bg-dark">
  {{ session('success') }}
</div>
@endif
<section>
<table>
  <tbody>
    <tr>
      <td><strong>ID</strong>:</td><td>{{ $user->id }}</td>
    </tr>
    <tr>
      <td><strong>Name</strong>:</td><td>{{ $user->fullName }}</td>
    </tr>
    <tr>
      <td><strong>Email</strong>:</td><td>{{ $user->email }}</td>
    </tr>
    <tr>
      <td><strong>Email Verified</strong>:</td>
      <td>{{ $user->email_verified ? 'True' : 'False' }}</td>
    </tr>
    <tr>
      <td><strong>Is Admin</strong>:</td>
      <td>{{ $user->is_admin ? 'True' : 'False' }}</td>
    </tr>
    <tr>
      <td><strong>Created</strong>:</td>
      <td>{{ longDateStr($user->created_at) }}</td>
    </tr>
    <tr>
      <td><strong>Updated</strong>:</td>
      <td>{{ longDateStr($user->updated_at) }}</td>
    </tr>
    <tr>
      <td class="button"><a href="{{ route('users.edit', $user->id) }}" class="link-button" role="button">Edit User</a></td>
      <td class="button button--right"><a href="{{ route('users.index') }}" class="link-button secondary" role="button">All Users &raquo;</a></td>
    </tr>
  </tbody>
</table>
</section>
@endsection
