<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListOrders extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListOrders()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
