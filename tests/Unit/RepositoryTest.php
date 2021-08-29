<?php

namespace Tests\Unit;

use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->php artisan --version('GET', '/users/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)
                ->where('name', 'Victoria Faith')
                ->missing('password')
                ->etc()
            );
    }
}
