@auth('admin')
  @if (auth('admin')->check())
    User: {{ auth('admin')->user()->fullName }} &lt;{{ auth('admin')->user()->email }}&gt;
    @if (auth('admin')->user()->is_admin)
      [Administrator]
    @endif
    | <form action="{{ route('auth.logout') }}" method="POST" style="display: inline">
      @csrf
      @method('POST')
      <button type="submit">Log Out</button>
    </form>
  @else
    <a class="link-button" href="{{ route('auth.index') }}">Log In</a><br>
  @endif
@else
  User: guest
@endauth
