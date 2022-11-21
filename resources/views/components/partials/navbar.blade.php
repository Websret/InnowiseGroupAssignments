<nav class="my-2 my-md-0 mr-md-3 my-nav">
    <a class="p-2 text-dark" href="/">Home</a>
    @if( auth()->check() )
        <div class="dropdown">
            <a class="p-2 text-dark my-item">{{ auth()->user()->name }} <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
            </a>
            <div class="dropdown-content">
                @if( auth()->user()->type_id == 2)
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                @endif
                <a href="{{ route('logout') }}">Log Out</a>
            </div>
        </div>
{{--        <a class="p-2 text-dark" href="/logout">Log Out</a>--}}
    @else
        <a class="p-2 text-dark" href="{{ route('login.create') }}">Log In</a>
        <a class="p-2 text-dark" href="{{ route('register.create') }}">Register</a>
    @endif
</nav>
