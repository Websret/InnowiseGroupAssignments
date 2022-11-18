<x-layouts.layout>
    <x-slot name="title">
        Product page
    </x-slot>
    <x-slot name="namepage">
        Product page
    </x-slot>

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $product[0]->name }}">
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

    </div>
</x-layouts.layout>
