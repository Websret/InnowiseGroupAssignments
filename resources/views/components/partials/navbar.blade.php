<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Task 22</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="/">Home</a>
        @if( auth()->check() )
            <p class="p-2 text-dark">Welcome {{ auth()->user()->name }}</p>
            <a class="text-dark" href="/logout">Log Out</a>
        @else
            <a class="text-dark" href="/login">Log In</a>
            <a class="text-dark" href="/register">Register</a>
        @endif
    </nav>
</div>

















