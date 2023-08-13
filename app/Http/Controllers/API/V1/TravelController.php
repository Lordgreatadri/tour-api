<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Travel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;

class TravelController extends Controller
{
    //shw all public travels
    public function index()  
    {
        $travels = Travel::where('is_public',true)->paginate();
        return TravelResource::collection($travels);
    }
}
