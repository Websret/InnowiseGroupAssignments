<x-layouts.layout>
    <x-slot name="title">
        Catalog page
    </x-slot>
    <x-slot name="namepage">
        Catalog page
    </x-slot>

    @foreach($products as $product)
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{ $product->name }}</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">{{ $product->cost }} <small class="text-muted">/
                            BYN</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>{{ $product->manufacture }}</li>
                        <li>{{ $product->type->type_name }}</li>
                        <li>{{ $product->release_date }}</li>
                        <li>{{ $product->description }}</li>
                    </ul>
                    <a href="/product/{{$product->id}}">
                        <button type="button" class="btn btn-lg btn-block btn-outline-primary">Open</button>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</x-layouts.layout>
