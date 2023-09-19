<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_connecting_to_methods_without_login()
    {
        $this->get('pets')->assertStatus(302)->assertRedirect('login');
        $this->get('pets/1')->assertStatus(302)->assertRedirect('login');
        $this->get('pets/create')->assertStatus(302)->assertRedirect('login');
        $this->post('pets',[])->assertStatus(302)->assertRedirect('login');
        $this->get('pets/1/edit')->assertStatus(302)->assertRedirect('login');
        $this->put('pets/1')->assertStatus(302)->assertRedirect('login');
        $this->delete('pets/1')->assertStatus(302)->assertRedirect('login');
    }

    public function test_it_can_create_a_pet()
    {
        //campos del formulario
        $data=[
            "name"=>$this->faker->firstName
        ];

        //Usuario registrado que va a crear la mascota
        $user=User::factory()->create();

        //Creacion de la solicitud
        $this
            ->actingAs($user)
            ->post('pets',$data)
            ->assertRedirect('pets');

        //Verificar en la base de datos que si se haya guardado los registros
        $this->assertDatabaseHas('pets',$data);
    }

    public function test_it_can_update_a_pet()
    {
        //creacion de una mascota para poder actualizar sus datos
        $pet=Pet::factory()->create();

        //campos del formulario con nueva informacion
        $data=[
            "name"=>$this->faker->firstName
        ];

        //Usuario registrado que va a actualizar la mascota
        $user=User::factory()->create();

        //Creacion de la solicitud
        $this
            ->actingAs($user)
            ->put("pets/$pet->id",$data)
            ->assertRedirect("pets/$pet->id/edit");

        //Verificar en la base de datos que si se haya guardado los registros
        $this->assertDatabaseHas('pets',$data);
    }


}
