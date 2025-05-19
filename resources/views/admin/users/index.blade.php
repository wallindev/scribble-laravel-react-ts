@extends('layouts.admin')

@section('content')
<h2>Users</h2>
@if ($errors->any())
<div class="user-msg text-danger bg-dark">
  <ul>
  @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
  @endforeach
  </ul>
</div>
@endif
@if (session('success'))
<div class="user-msg text-success bg-dark">
  {{ session('success') }}
</div>
@endif
<section>
<div style="margin: 1.5rem .5rem;"><a href="{{ route('users.create') }}">Create User</a></div>
<table>
  <thead>
    <tr class="heading">
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th colspan="3">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($users as $user)
    @php $userUrl = route('users.show', $user->id); @endphp
    <tr>
      <td><a href="{{ $userUrl }}">{{ $user->id }}</a></td>
      <td><a href="{{ $userUrl }}">{{ $user->fullName }}</a></td>
      <td><a href="{{ $userUrl }}">{{ $user->email }}</a></td>
      <td><a href="{{ $userUrl }}" class="link-button" role="button">Show</a></td>
      <td><a href="{{ route('users.edit', $user->id) }}" class="link-button" role="button">Edit</a></td>
      <td>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Delete this user?');" class="link-button secondary">Delete</a>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
</section>
@endsection
