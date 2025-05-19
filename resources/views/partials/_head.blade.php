    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/svg+xml" href="/img/scribble-bold.svg" />
  @if (file_exists(public_path('hot')))
    @vite(['resources/css/app.styl', 'resources/js/app.js'])
  @else
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.styl') }}">
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>
  @endif
    <title>{{ $pageTitle }} - {{ config('app.name', 'Scribble! (from Blade)') }}</title>
