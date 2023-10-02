<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TourListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_tours_list_by_travel_slug_returned_correct_tour(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travel_id' => $travel->id]);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $tour->id]);
    }


    public function test_tour_price_is_shown_correctly(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 123.96
        ]);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['price' => '123.96']);
    }



    public function test_tour_list_return_pagination(): void
    {
        // let's set up a fake database to create a fake data for out test
        // uncomment the database detail in the phpunit.xmx file to be used 
        $tourPerPage = config('app.paginationPerPage.tours');

        $travel = Travel::factory()->create(['is_public'=>true]);
        $tour = Tour::factory($tourPerPage + 1)->create(['travel_id' => $travel->id]);


        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount($tourPerPage, 'data');
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_tour_list_sorts_by_starting_date_corretly(): void
    {
        $travel    = Travel::factory()->create();
        $latertour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price'     => 123.96,
            'starting_date' => now()->addDays(2),
            'ending_date'   => now()->addDays(3),
        ]);
        $earliertour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price'     => 120,
            'starting_date' => now(),
            'ending_date'   => now()->addDays(1),
        ]);


        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', $earliertour->id);
        $response->assertJsonPath('data.1.id', $latertour->id);
    }

}
