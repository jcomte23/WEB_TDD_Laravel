<?php

namespace Tests\Feature\Http\Controllers\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetControllerTest extends TestCase
{

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
}
