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

    public function test_store_method_without_valid_fields()
    {
        //Usuario registrado que va a intentar crear la mascota
        $user=User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->post('pets',[])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function test_store_method_can_create_a_pet()
    {
        //Campos del formulario
        $data=[
            "name"=>$this->faker->firstName
        ];

        //Usuario registrado que va a crear la mascota
        $user=User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->post('pets',$data)
            ->assertRedirectToRoute('pets.index');

        //Verificar en la base de datos que si se haya guardado la mascota
        $this->assertDatabaseHas('pets',$data);
    }

    public function test_update_method_without_valid_fields()
    {
        //Creacion de una mascota para intentar actualizar sus datos
        $pet=Pet::factory()->create();

        //Usuario registrado que va a intentar actualizar la mascota
        $user=User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->put("pets/$pet->id",[])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function test_update_method_can_update_a_pet()
    {
        //Creacion de una mascota para poder actualizar sus datos
        $pet=Pet::factory()->create();

        //Campos del formulario con nueva informacion
        $data=[
            "name"=>$this->faker->firstName
        ];

        //Usuario registrado que va a actualizar la mascota
        $user=User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->put("pets/$pet->id",$data)
            ->assertRedirectToRoute('pets.edit',$pet->id);

        //Verificar en la base de datos que si se haya actualizado la mascota
        $this->assertDatabaseHas('pets',$data);
    }

    public function test_destroy_method_can_delete_a_pet()
    {
        //Creacion de mascota
        $pet=Pet::factory()->create();

        //Usuario registrado que va a eliminar la mascota
        $user=User::factory()->create();

        //Solicitud Http
        $this
            ->actingAs($user)
            ->delete("pets/$pet->id")
            ->assertRedirectToRoute('pets.index');

        //Verificar en la base de datos que si se haya eliminado la mascota
        $this->assertDatabaseMissing('pets', $pet->toArray());
    }

}
