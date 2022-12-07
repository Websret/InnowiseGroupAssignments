<x-layouts.layout>
    <x-slot name="title">
        Create product page
    </x-slot>
    <x-slot name="namepage">
        Create product
    </x-slot>

    <h2>Create product</h2>
    <form method="POST" action="{{ route('product.store') }}">
        <x-partials.formerrors/>
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="form-group">
            <label for="manufacture">Manufacture:</label>
            <input type="text" class="form-control" id="manufacture" name="manufacture">
        </div>

        <div class="form-group">
            <label for="release_date">Release date:</label>
            <input type="date" class="form-control" id="release_date" name="release_date">
        </div>

        <div class="form-group">
            <label for="cost">Price:</label>
            <input type="text" class="form-control" id="cost" name="cost">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>

        <div class="form-group">
            <label for="product_type">Product type:</label>
            <select name="product_type" id="product_type" class="form-control form-control-lg">
                @foreach($productTypes as $values)
                        <option value="{{ $values->id }}">{{ $values->type_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
</x-layouts.layout>
