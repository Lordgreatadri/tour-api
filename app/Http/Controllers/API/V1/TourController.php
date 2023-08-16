<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;

class TourController extends Controller
{

    public function index(Travel $travel, Request $request)
    {
        // return Tour::where('travel_id', $travel->id)->orderBy('starting_date', 'asc')->get(); OR use relationship
        #$tour =  $travel->tours()
            #->orderBy('starting_date', 'asc')
            #->paginate();

            
            $tour =  $travel->tours()
            ->when($request->priceFrom, function($query) use($request){
                $query->when('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function($query) use($request){
                $query->when('price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, function($query) use($request){
                $query->when('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function($query) use($request){
                $query->when('starting_date', '<=', $request->dateTo);
            })
            ->orderBy('starting_date', 'asc')
            ->paginate();

            return TourResource::collection($tour);    
    }
}
