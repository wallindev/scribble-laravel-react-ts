@extends('layouts.admin')

@section('content')
<h2>Admin Start Page</h2>
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
<table>
  <tbody>
  @foreach ($links as $uri => $text)
    <tr>
      <td><a href="{{ $uri }}">{{ $text }}</a></td>
    </tr>
  @endforeach
  </tbody>
</table>
</section>
@endsection
