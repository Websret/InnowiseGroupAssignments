<x-layouts.layout>
    <x-slot name="title">
        Log In page
    </x-slot>
    <x-slot name="namepage">
        Log In page
    </x-slot>

    <h2>Log In</h2>

    <form method="POST" action="/login">
        {{ csrf_field() }}
        <x-partials.formerrors/>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</x-layouts.layout>
