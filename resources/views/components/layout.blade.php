<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DormAItrics</title>
    <link rel="shortcut icon" href="images/spumlogo.png">
    @vite(['resources/css/main.css', 'resources/js/app.js']) {{-- css stylesheet --}}
</head>
<body>
    <nav id="sidebar">
        <header class="text header-text">DormAItrics</header>
        <div class="nav-links"> 
            <div class="menu-bar">
                {{-- all nav --}}
                <ul class="menu-links">
                    <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}">Announcements</a></li>
                    <li><a href="{{ route('reviews') }}" class="nav-link {{ request()->routeIs('reviews') || request()->is('/reviews') ? 'active' : '' }}">Reviews</a></li>
                    <li><a href="{{ route('concerns') }}" class="nav-link {{ request()->routeIs('concerns') || request()->is('/concerns') ? 'active' : '' }}">Concerns</a></li>
                    @if (auth()->user()->isResident())
                        <li><a href="{{ route('pass-slips') }}" class="nav-link {{ request()->routeIs('pass-slips') || request()->is('/pass-slips') ? 'active' : '' }}">Pass Slips</a></li>
                    @endif
                </ul>
                <br>
                {{-- admin nav --}}
                @if (auth()->user()->isAdmin())
                    <header class="text header-text">Dormitory Management System</header>
                    <ul class="menu-links">
                        <li><a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') || request()->is('/users') ? 'active' : '' }}">Residents</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="nav-link {{ request()->routeIs('rooms.*') || request()->is('/rooms') ? 'active' : '' }}">Room Management</a></li>
                        <li><a href="{{ route('slips-mgmt') }}" class="nav-link {{ request()->routeIs('slips-mgmt') || request()->is('/slips-mgmt') ? 'active' : '' }}">Pass Slip Management</a></li>
                        <li><a href="{{ route('reports') }}" class="nav-link {{ request()->routeIs('reports') || request()->is('/logbook') ? 'active' : '' }}">Reports</a></li>
                        <li><a href="{{ route('analytics.index') }}" class="nav-link {{ request()->routeIs('analytics.*') || request()->is('/analytics') ? 'active' : '' }}">Analytics</a></li>
                        <li><a href="{{ route('facial-recognition') }}" class="nav-link {{ request()->routeIs('facial-recognition') || request()->is('/facial-recognition') ? 'active' : '' }}">Facial Recognition</a></li>
                    </ul>
                @endif
            </div>

            <div class="bottom-content">
                <div class="column left-column"><a href="{{ route('profile') }}"><img src="{{ asset(auth()->user()->profile_picture) }}" alt="User" class="user-profile"></div>
                <div class="column middle-column">Hi! {{ Auth::user()->nickname }}</a></div>
                <div class="column right-column"><a href="{{ route('logout') }}"><img src="{{ asset('images/logout.png') }}" alt="logout" class="logout-icon"></a></div>
            </div>
        </div>
    </nav>
    <main id="content">
        {{ $slot }}
    </main>
</body>
</html>