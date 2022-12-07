<x-layouts.layout>
    <x-slot name="title">
        Dashboard page
    </x-slot>
    <x-slot name="namepage">
        Dashboard
    </x-slot>

    <p>Export catalog in csv file -
        <a href="{{ route('csv.export') }}">
            <button type="button" class="btn btn-secondary">Export</button>
        </a>
    </p>
    <x-dashboard.products :products=$products/>
    <hr>
    <br>
    <x-dashboard.services :services=$services/>

</x-layouts.layout>
