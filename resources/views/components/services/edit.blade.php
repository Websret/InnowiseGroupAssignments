<x-layouts.layout>
    <x-slot name="title">
        Edit service page
    </x-slot>
    <x-slot name="namepage">
        Edit service
    </x-slot>

    <h2>Edit service</h2>
    <form method="POST" action="/service/{{ $service[0]->id }}">
        @method('PUT')
        <x-partials.formerrors/>
        {{ csrf_field() }}
        <div class="form-group">
            <label for="service_name">Name:</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="{{ $service[0]->service_name }}">
        </div>

        <div class="form-group">
            <label for="deadline">Deadline:</label>
            <input type="text" class="form-control" id="deadline" name="deadline" value="{{ $service[0]->deadline }}">
        </div>

        <div class="form-group">
            <label for="service_cost">Cost:</label>
            <input type="text" class="form-control" id="service_cost" name="service_cost" value="{{ $service[0]->service_cost }}">
        </div>

        <div class="form-group">
            <label for="product_type">Product types:</label>
            @foreach($productTypes as $key => $value)
                <br>
                <input type="checkbox" id="product_type" name="product_type[]" value="{{ $value->id }}">{{ $value->type_name }}
            @endforeach
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</x-layouts.layout>
