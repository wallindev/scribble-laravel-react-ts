@extends('layouts.admin')

@section('content')
<h2>Articles</h2>
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
<div style="margin: 1.5rem .5rem;"><a href="{{ route('articles.create') }}">Create Article</a></div>
<table>
  <thead>
    <tr class="heading">
      <th>ID</th>
      <th>Title</th>
      <th>Content</th>
      <th colspan="3">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($articles as $article)
    @php $articleUrl = route('articles.show', $article->id); @endphp
    <tr>
      <td><a href="{{ $articleUrl }}">{{ $article->id }}</a></td>
      <td><a href="{{ $articleUrl }}">{{ $article->title }}</a></td>
      <td><a href="{{ $articleUrl }}">{{ contentStub($article->content) }}</a></td>
      <td><a href="{{ $articleUrl }}" class="link-button" role="button">Show</a></td>
      <td><a href="{{ route('articles.edit', $article->id) }}" class="link-button" role="button">Edit</a></td>
      <td>
        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Delete this article?');" class="link-button secondary">Delete</a>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
