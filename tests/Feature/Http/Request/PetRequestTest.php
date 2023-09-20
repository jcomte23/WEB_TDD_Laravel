<?php

namespace Tests\Feature\Http\Request;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetRequestTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_create_a_pet_with_invalid_fields()
    {
        //Usuario registrado que va a intentar crear la mascota
        $user = User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->post('pets', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function test_update_a_pet_with_invalid_fields()
    {
        //Creacion de una mascota para intentar actualizar sus datos
        $pet = Pet::factory()->create();

        //Usuario registrado que va a intentar actualizar la mascota
        $user = User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->put("pets/$pet->id", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }
}
