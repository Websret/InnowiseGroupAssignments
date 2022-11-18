<x-layouts.layout>
    <x-slot name="title">
        Edit product page
    </x-slot>
    <x-slot name="namepage">
        Edit product
    </x-slot>

    <h2>Edit product</h2>
    <form method="POST" action="/product/{{ $product[0]->id }}/edit">
        @method('PUT')
        <x-partials.formerrors/>
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product[0]->name }}">
        </div>

        <div class="form-group">
            <label for="manufacture">Manufacture:</label>
            <input type="text" class="form-control" id="manufacture" name="manufacture" value="{{ $product[0]->manufacture }}">
        </div>

        <div class="form-group">
            <label for="release_date">Release date:</label>
            <input type="date" class="form-control" id="release_date" name="release_date" value="{{ $product[0]->release_date }}">
        </div>

        <div class="form-group">
            <label for="cost">Price:</label>
            <input type="text" class="form-control" id="cost" name="cost" value="{{ $product[0]->cost }}">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $product[0]->description }}">
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
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</x-layouts.layout>
