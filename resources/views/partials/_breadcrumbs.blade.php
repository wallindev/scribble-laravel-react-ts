@foreach ($breadcrumbs as $linkHref => $linkText)
  @if ($loop->last)
    {{ $linkText }}
  @else
    <a href="{{ $linkHref }}" title="To {{ $linkText }} Page">{{ $linkText }}</a> &raquo;
  @endif
@endforeach
