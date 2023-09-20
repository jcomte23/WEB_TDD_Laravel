<?php

namespace Tests\Feature\Policies;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetPolicyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_impossible_update_a_pet_without_access_policy()
    {
        //Creacion de una mascota la cual trae su propio usuario
        $pet = Pet::factory()->create();

        //Campos del formulario con nueva informacion
        $data = [
            "name" => $this->faker->firstName
        ];

        //Usuario B que va intentar actualizar la mascota
        $user = User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->put("pets/$pet->id", $data)
            ->assertStatus(403);
    }

    public function test_impossible_delete_a_pet_without_access_policy()
    {
        //Usuario que va a intentar eliminar la mascota
        $user = User::factory()->create();

        //Mascota que pertenece a otro usuario
        $pet = Pet::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->delete("pets/$pet->id")
            ->assertStatus(403);
    }
}
