<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Travel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TravelsListTest extends TestCase
{
    use RefreshDatabase;
     
    /**
     * A basic feature test example.
     */
    public function test_travels_list_data_returns_paginated_data_correctly(): void
    {
        // let's set up a fake database to create a fake data for out test
        // uncomment the database detail in the phpunit.xmx file to be used 

        Travel::factory(16)->create(['is_public'=>true]);

        $response = $this->get('/api/v1/travels');

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 2);
    }


    public function test_travels_list_show_only_public_records(): void
    {
        // let's set up a fake database to create a fake data for out test
        // uncomment the database detail in the phpunit.xmx file to be used 

        $travel = Travel::factory()->create(['is_public'=>true]);
        // Travel::factory()->create(['is_public'=>false]);

        $response = $this->get('/api/v1/travels');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.name', $travel->name);
    }
}
