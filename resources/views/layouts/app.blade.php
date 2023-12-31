@php
$admin = Auth::guard('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
      // Fix for Firefox autofocus CSS bug
      // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous" defer></script>
    <script src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body class="d-flex flex-column min-vh-100">
    <header>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark px-2">
        <div class="container-fluid">
          <a class="navbar-brand fs-3" href="{{ url('/') }}">EVENTURE</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse mt-3 mt-md-0" id="navbarContent">
            <div class="col d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-end gap-2 gap-md-3">
              <form {{ Route::is('events.search-results') ? 'id=searchEventsForm' : ''}} method="GET" action="{{ Route::is('events.search-results') ? route('api.events.search-results') : route('events.search-results') }}">
                <div class="input-group">
                  <input type="search" class="form-control" placeholder="Search events..." aria-label="Search" name="query" value="{{ Request::get('query') ?? old('query') }}" required>
                  <button type="submit" class="btn btn-outline-light"><i class="fa fa-search"></i></button>
                </div>
              </form>
              @if (Auth::check())
                <a href="{{ route('events.new') }}" role="button" class="btn btn-primary d-flex gap-2 justify-content-center align-items-center">Create event <i class="fa fa-plus"></i></a>
                @php $user = Auth::user() @endphp
                <div class="dropdown">
                  <a href="#" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle avatar-small" src="{{ is_null($user->picture) ? asset('img/profile_default.png') : 'data:image/jpeg;base64, ' . $user->picture }}" alt="Profile picture">
                  </a>
                  <ul id="dropdownUserItems" class="dropdown-menu dropdown-menu-end ps-0 gap-2" aria-labelledby="dropdownUser">
                    <li><a href="{{ route('users.profile', ['username' => $user->username]) }}" class="dropdown-item d-block">My Profile</a></li>
                    <li><a href="{{ route('users.profile.edit', ['username' => $user->username]) }}" class="dropdown-item d-block">Edit Profile</a></li>
                    <li><a href="{{ route('users.profile.events', ['username' => $user->username]) }}" class="dropdown-item d-block">My Events</a></li>
                    <li><a href="{{ route('users.profile.invitations', ['username' => $user->username]) }}" class="dropdown-item d-block">My Invitations</a></li>
                    <li>
                      <form method="POST" action="{{ route('sign-out') }}" class="d-flex flex-column align-items-stretch">
                        @csrf
                        <button type="submit" class="dropdown-item d-block">Sign out</button>
                      </form>
                    </li>
                  </ul>
                </div>
              @elseif (is_null($admin))
                <a href="{{ url('/sign-in') }}" role="button" class="btn btn-outline-light">Sign in</a>
                <a href="{{ url('/sign-up') }}" role="button" class="btn btn-outline-light">Sign up</a>
              @else
                <div class="dropdown">
                  <button id="dropdownUser" type="button" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-outline-light dropdown-toggle">Administrator: <b>{{ $admin->username }}</b></button>
                  <ul id="dropdownUserItems" class="dropdown-menu dropdown-menu-end ps-0 gap-2" aria-labelledby="dropdownUser">
                    <li><a href="{{ route('admin.user-management') }}" class="dropdown-item d-block">User management</a></li>
                    <li>
                      <form method="POST" action="{{ route('admin.sign-out') }}" class="d-flex flex-column align-items-stretch">
                        @csrf
                        <button type="submit" class="dropdown-item d-block">Sign out</button>
                      </form>
                    </li>
                  </ul>
                </div>
              @endif
            </div>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <section id="content">
        @yield('content')
      </section>
    </main>

    <footer class="mt-auto bg-light">
      <div class="container p-3">
        <div class="row">
          <div class="col-md mb-2">
            <span>© Copyright 2021 Eventure</span>
          </div>
          <div class="col-md mb-2">
            <h5 class="text-uppercase">Help</h5>
            <ul class="list-unstyled">
              <li><a class="text-primary" href="{{ url('/about') }}">About</a></li>
              <li><a class="text-primary" href="{{ url('/contacts') }}">Contacts</a></li>
              <li><a class="text-primary" href="{{ url('/faq') }}">FAQ</a></li>
            </ul>
          </div>
          @if (!is_null($admin))
          <div class="col-md">
            <h5 class="text-uppercase">Administration</h5>
            <ul class="list-unstyled">
              <li><a class="text-primary" href="{{ route('admin.user-management') }}">User management</a></li>
              <li><a class="text-primary" href="user_metrics.php">User metrics</a></li>
              <li><a class="text-primary" href="event_metrics.php">Event metrics</a></li>
            </ul>
          </div>
          @endif
        </div>
      </div>
    </footer>
  </body>
</html>
