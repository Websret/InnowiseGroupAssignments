<x-layouts.layout>
    <x-slot name="title">
        Product page
    </x-slot>
    <x-slot name="namepage">
        Product page
    </x-slot>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="name">Name:</label>
                <p>{{ $product[0]->name }}</p>
            </div>

            <div class="form-group">
                <label for="manufacture">Manufacture:</label>
                <p>{{ $product[0]->manufacture }}</p>
            </div>

            <div class="form-group">
                <label for="release_date">Release date:</label>
                <p>{{ $product[0]->release_date }}</p>
            </div>

            <div class="form-group">
                <label for="cost">Price:</label>
                <p id="product-price">{{ $product[0]->cost }}</p>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <p>{{ $product[0]->description }}</p>
            </div>

            <div class="form-group">
                <label for="product_type">Product type:</label>
                <p>{{ $product[0]->type->type_name }}</p>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="service">Access services:</label>
                <form action="" id="our-form">
                    @foreach($services->type->service as $key => $value)
                        <br>
                        <input type="checkbox" name="item-{{ $key }}" id="item-{{ $key }}"
                               value="{{ $value->service_cost }}">
                        {{ $value->service_name }}, price: {{ $value->service_cost }},
                        deadline: {{ $value->deadline }}

                    @endforeach
                </form>
            </div>

            <p>Total price: <span id="checked-sum">0</span></p>
        </div>
    </div>
</x-layouts.layout>
