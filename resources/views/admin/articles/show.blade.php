@extends('layouts.admin')

@section('content')
<h2>Article Details</h2>
@if (session('success'))
<div class="user-msg text-success bg-dark">
  {{ session('success') }}
</div>
@endif
<section>
<table class="show">
  <tbody>
    <!--<tr>
      <td><strong>ID</strong>:</td>
      <td>{{ $article->id }}</td>
    </tr>-->
    <tr>
      <td class="heading"><strong>Title</strong>:</td>
      <td class="content"><div>{{ $article->title }}</div></td>
    </tr>
    <tr>
      <td class="heading"><strong>Content</strong>:</td>
      <td class="content"><div>{!! newLineToBr($article->content) !!}</div></td>
    </tr>
    <tr>
      <td><strong>Created</strong>:</td>
      <td>{{ longDateStr($article->created_at) }}</td>
    </tr>
    <tr>
      <td><strong>Updated</strong>:</td>
      <td>{{ longDateStr($article->updated_at) }}</td>
    </tr>
    <tr>
      <td class="button"><a href="{{ route('articles.edit', $article->id) }}" class="link-button" role="button">Edit Article</a></td>
      <td class="button button--right"><a href="{{ route('articles.index') }}" class="link-button secondary" role="button">All Articles &raquo;</a></td>
    </tr>
  </tbody>
</table>
</section>
@endsection
