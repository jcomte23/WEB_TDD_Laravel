<?php

namespace Tests\Unit\Web\Models;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetTest extends TestCase
{
    use RefreshDatabase;

    public function test_pet_belong_to_user()
    {
        $pet=Pet::factory()->create();
        $this->assertInstanceOf(User::class,$pet->user);
    }
}
