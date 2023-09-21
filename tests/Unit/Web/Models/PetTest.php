<?php

namespace Tests\Unit\Web\Models;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PetTest extends TestCase
{
    use RefreshDatabase;

    public function test_pet_belongs_to_user()
    {
        $pet = Pet::factory()->create();
        $this->assertInstanceOf(User::class, $pet->user);
    }

    public function test_the_scope_list_my_pets()
    {
        //Creamos un usuario con el cual nos logeamos
        $user = User::factory()->create();
        Auth::login($user);

        //Creamos unas mascotas y se las asignamos al usuario
        $userPets = Pet::factory(3)->create(['user_id' => $user->id]);

        //Creamos otras mascotas las cuales se asignan automaticamente a otros usuarios
        $otherPets = Pet::factory(3)->create();

        //Aplicamos el scope y obtener las mascotas del usuario autenticado
        $result = Pet::listMyPets()->get();

        // Verificar que solo las mascotas del usuario autenticado estén presentes
        $this->assertCount(3, $result);

        foreach ($userPets as $pet) {
            $this->assertTrue($result->contains($pet));
        }
        
        foreach ($otherPets as $pet) {
            $this->assertFalse($result->contains($pet));
        }
    }
}
