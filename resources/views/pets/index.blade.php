<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>listado de pets</h1>
    @forelse ($pets as $pet)
        <h1>{{ $pet->id }}</h1>
        <h2>{{ $pet->name }}</h2>
    @empty
        <h1>No tienes mascotas registradas</h1>
    @endforelse
</body>
</html>