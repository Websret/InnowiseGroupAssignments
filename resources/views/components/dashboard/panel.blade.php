<x-layouts.layout>
    <x-slot name="title">
        Dashboard page
    </x-slot>
    <x-slot name="namepage">
        Dashboard
    </x-slot>

    <x-dashboard.products :products=$products />
    <hr>
    <br>
    <x-dashboard.services :services=$services />

</x-layouts.layout>
