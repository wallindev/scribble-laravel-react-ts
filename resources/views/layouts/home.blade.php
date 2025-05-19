<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    @include('partials._head', ['pageTitle' => 'Home'])
  </head>
  <body>
    <header class="header">
      @include('partials._header')
    </header>
    <main class="main">
      @yield('content')
    </main>
    <footer class="footer">
      @include('partials._footer')
    </footer>
  </body>
</html>
