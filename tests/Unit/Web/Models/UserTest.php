<?php

namespace Tests\Unit\Web\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_many_pets(): void
    {
        $user=new User();
        $this->assertInstanceOf(Collection::class,$user->pets);
    }
}
