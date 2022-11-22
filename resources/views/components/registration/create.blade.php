<x-layouts.layout>
    <x-slot name="title">
        Registration page
    </x-slot>
    <x-slot name="namepage">
        Registration page
    </x-slot>

    <h2>Register</h2>
    <form method="POST" action="{{ route('register.store') }}">
        <x-partials.formerrors/>
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Password Confirmation:</label>
            <input type="password" class="form-control" id="password_confirmation"
                   name="password_confirmation">
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</x-layouts.layout>
