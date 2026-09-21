<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DormAItrics</title>
    <link rel="shortcut icon" href="images/spumlogo.png">
    @vite(['resources/css/main.css', 'resources/js/app.js'])
</head>
<body>
    <nav id="sidebar">
        <header class="text header-text">DormAItrics</header>
        <div class="nav-links"> 
            <div class="menu-bar">
                {{-- all nav --}}
                <ul class="menu-links">
                    <li>
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') || request()->is('/home') ? 'active' : '' }}">Announcements</a></li>
                    <li><a href="" class="nav-link">Reviews</a></li>
                    <li><a href="" class="nav-link">Concerns</a></li>
                </ul>
                <br>
                {{-- admin nav --}}
                @if (auth()->user()->isAdmin())
                    <header class="text header-text">Dormitory Management System</header>
                    <ul class="menu-links">
                        <li><a href="{{ route('dormer-mgmt') }}" class="nav-link {{ request()->routeIs('dormer-mgmt') || request()->is('/dormer-mgmt') ? 'active' : '' }}">Dormer Management</a></li>
                        <li><a href="" class="nav-link">Room Management</a></li>
                        <li><a href="" class="nav-link">Reports</a></li>
                        <li><a href="" class="nav-link">Analytics</a></li>
                        <li><a href="" class="nav-link">Biometrics</a></li>
                    </ul>
                @endif
            </div>

            <div class="bottom-content">
                <div class="column left-column"><a href="#"><img src="{{ asset('images/user-profile.png') }}" alt="User" class="user-profile"></div>
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