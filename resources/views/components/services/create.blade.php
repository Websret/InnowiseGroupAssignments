<x-layouts.layout>
    <x-slot name="title">
        Service create page
    </x-slot>
    <x-slot name="namepage">
        Create service
    </x-slot>

    <h2>Create service</h2>
    <form method="POST" action="/service/create">
        <x-partials.formerrors/>
        {{ csrf_field() }}
        <div class="form-group">
            <label for="service_name">Name:</label>
            <input type="text" class="form-control" id="service_name" name="service_name">
        </div>

        <div class="form-group">
            <label for="deadline">Deadline:</label>
            <input type="text" class="form-control" id="deadline" name="deadline">
        </div>

        <div class="form-group">
            <label for="service_cost">Cost:</label>
            <input type="text" class="form-control" id="service_cost" name="service_cost">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
</x-layouts.layout>
