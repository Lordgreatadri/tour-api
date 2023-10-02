<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Http\Requests\TourListRequest;

class TourController extends Controller
{

    public function index(Travel $travel, TourListRequest $request)
    {

        //return Tour::where('travel_id', $travel->id)->orderBy('starting_date', 'asc')->get(); //OR use relationship
        // $tours =  $travel->tours()
        //     ->orderBy('starting_date', 'asc')
        //     ->paginate();


            // $tours =  $travel->tours()
            //     ->when($request->priceFrom, function($query) use($request){
            //         $query->when('price', '>=', $request->priceFrom * 100);
            //     })
            //     ->when($request->priceTo, function($query) use($request){
            //         $query->when('price', '<=', $request->priceTo * 100);
            //     })
            //     ->when($request->dateFrom, function($query) use($request){
            //         $query->when('starting_date', '>=', $request->dateFrom);
            //     })
            //     ->when($request->dateTo, function($query) use($request){
            //         $query->when('starting_date', '<=', $request->dateTo);
            //     })
            //     ->when($request->sortBy && $request->sortOrderBy, function($query) use($request){
            //         $query->orderBy($request->sortBy, $request->sortOrderBy);
            //     })
            //     ->orderBy('starting_date')
            //     ->paginate();     

                    //OR you can ALSO use the below
            
                $query =  $travel->tours();
                // Check if 'dateFrom' parameter is provided
                if (request()->has('dateFrom')) {
                    $dateFrom = request()->input('dateFrom');
                    $query->where('starting_date', '>=', $dateFrom);
                }

                // Check if 'dateTo' parameter is provided
                if (request()->has('dateTo')) {
                    $dateTo = request()->input('dateTo');
                    $query->where('starting_date', '<=', $dateTo);
                }

                // Check if 'priceFrom' parameter is provided
                if (request()->has('priceFrom')) {
                    $priceFrom = request()->input('priceFrom');
                    $query->where('price', '>=', $priceFrom);
                }

                // Check if 'priceTo' parameter is provided
                if (request()->has('priceTo')) {
                    $priceTo = request()->input('priceTo');
                    $query->where('price', '<=', $priceTo);
                }

                // Check for sorting parameters
                if (request()->has('sortBy') && request()->has('sortOrderBy')) {
                    $sortBy = request()->input('sortBy');
                    $sortOrderBy = request()->input('sortOrderBy');

                    // Validate and sanitize the sorting parameters to prevent SQL injection
                    // $validSortColumns = ['price', 'starting_date', 'name', 'ending_date', 'id']; // Add more columns if needed
                    // if (in_array($sortBy, $validSortColumns) && in_array($sortOrderBy, ['asc', 'desc'])) {
                    //     $query->orderBy($sortBy, $sortOrderBy);
                    // }

                    // BUT WE ARE USING FormRequest for our validation
                }

                // Execute the query
                $tours = $query->paginate();

                // You can return or work with the $results as needed
                // ->paginate();
            return TourResource::collection($tours);    
    }
}
