<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <h1>listado de pets</h1>
                @forelse ($pets as $pet)
                    <h1>{{ $pet->id }}</h1>
                    <h2>{{ $pet->name }}</h2>
                @empty
                    <h1>No tienes mascotas registradas</h1>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>