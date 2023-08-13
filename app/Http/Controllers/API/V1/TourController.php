<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;

class TourController extends Controller
{

    public function index(Travel $travel)
    {
        // return Tour::where('travel_id', $travel->id)->orderBy('starting_date', 'asc')->get(); OR use relationship
        $tour =  $travel->tours()
            ->orderBy('starting_date', 'asc')
            ->paginate();

            return TourResource::collection($tour);    
    }
}
