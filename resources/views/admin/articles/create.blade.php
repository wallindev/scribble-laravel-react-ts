@extends('layouts.admin')

@section('content')
<h2>Create Article</h2>
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
<form action="{{ route('articles.store') }}" method="POST">
  @csrf
  @method('POST')
  <table>
    <tbody>
      <tr>
        <td class="heading"><label for="title">Title</label>:</td>
        <td class="content"><input type="text" id="title" name="title" value="{{ old('title') }}" required></td>
      </tr>
      <tr>
        <td class="heading"><label for="content">Content</label>:</td>
        <td class="content"><textarea type="text" id="content" name="content" required>{{ old('content') }}</textarea></td>
      </tr>
      <tr>
        <td class="heading"><label for="user">User</label>:</td>
        <td class="content">
          <select id="user_id" name="user_id">
          @foreach ($users as $user)
            @php
              $selected = $user->id == auth('admin')->user()->id && $user->is_admin;
              //echo("Is logged in and is admin: $selected<br>\n");
            @endphp
            <option value="{{ $user->id }}" @selected($selected)>{{ $user->fullName }}</option>
          @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <td class="button"><button type="submit" class="link-button">Save Article</button></td>
        <td class="button button--right"><a href="{{ route('articles.index') }}" class="link-button secondary" role="button">Cancel</a></td>
      </tr>
    </tbody>
  </table>
</form>
</section>
@endsection

<script>
  // Set height to scrollHeight plus the y padding
  const adjustSize = (textArea) => {
    textArea.style.height = 'auto';
    textArea.style.height = `calc(${textArea.scrollHeight}px + ${getComputedStyle(textArea).paddingBlock})`
  }
  const handleInput = () => {
    const textArea = document.getElementById('content')
    adjustSize(textArea)
  }
  window.onload = () => {
    const textArea = document.getElementById('content')
    textArea.addEventListener('input', handleInput)
    adjustSize(textArea)
  }
</script>
