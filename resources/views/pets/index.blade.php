<x-app-layout>

    <div class="py-6">
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