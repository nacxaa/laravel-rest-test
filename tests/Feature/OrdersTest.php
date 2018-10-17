<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersTest extends TestCase
{
    public function testListOrders()
    {
        $this->json('get', '/api/orders', [], [])
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' => ['id', 'status', 'products', 'created_at', 'updated_at'],
        ]);
    }

    public function testCreateOrder()
    {
        $this->json('post', '/api/order', 
            ["sent"=>1, 
             "items"=>[["productId"=> 1, "quantity"=>1], ["productId"=>2, "quantity"=>1]],
             "ip"=>"5.53.1.169"],
            ["Accept" => "application/json", "Content-Type"=> "application/json"])
        ->assertStatus(200);
    }

    public function testCreateTooManyOrders()
    {
        $this->testCreateOrder();
        $this->testCreateOrder();
        $this->testCreateOrder();

        $this->json('post', '/api/order', 
            ["sent"=>1, 
             "items"=>[["productId"=> 1, "quantity"=>1], ["productId"=>2, "quantity"=>1]],
             "ip"=>"5.53.1.169"],
            ["Accept" => "application/json", "Content-Type"=> "application/json"])
        ->assertStatus(422)
        ->assertJson([
            "message"=> "The given data was invalid.",
            "errors"=> [
                "order"=> [
                    "You submit orders too fast"
                ]
            ]
        ]);
        
    
    }

}
