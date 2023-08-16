<?php

namespace App\Http\Controllers\UnitySMS;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Unity\DailyBilled;
use App\Models\Unity\DailyUpdate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DailyReportsController extends Controller
{
    //
    public function index(Request $request) {
        // Log::info($request);
        $date = Carbon::now();

        // DailyBilled::whereDate('created_at', date('Y-m-d'))->get();

        $dailyBilled = DailyBilled::whereDate('created_at', $date->today()->toDateString())
                        ->first();

        $dailyUpdate = DailyUpdate::where('service', $request->service_id)
                        ->whereDate('created_at', $date->today()->toDateString())
                        ->first();
        $sentCount = DailyUpdate::query()
                        ->whereDate('created_at', $date->today()->toDateString())
                        ->sum('total_sms_sent');
                        // ->sum('total_delivery')
        $deliveryCount = DailyUpdate::query()
                        ->whereDate('created_at', $date->today()->toDateString())
                        ->sum('total_delivery');                

        // Log::info($dailyUpdate);
        Log::info($sentCount);
        Log::info($deliveryCount);

        if($request->status === "EXPIRED" && $request->reason === "DeliveryImpossible")   
        {
            if(empty($dailyUpdate)){
                DailyUpdate::create([
                    "keyword" => $this->getKeyword($request->service_id),
                    "service" => $request->service_id,
                    "total_sms_sent" => 1
                ]);
            }else{
                DailyUpdate::where('id', $dailyUpdate->id)->update([
                    "total_sms_sent" => $dailyUpdate->total_sms_sent + 1
                ]);
            }

            if($dailyBilled === null){
                DailyBilled::create([
                    "total_sms_sent" => $sentCount,
                    "total_delivery" => $deliveryCount,
                ]);
            }else{
                DailyBilled::where('id', $dailyBilled->id)->update([
                    "total_sms_sent" => $sentCount,
                    "total_delivery" => $deliveryCount,
                ]);
            }
        }elseif($request->status === "DELIVRD" && $request->reason === "DeliveredToTerminal")   
        {
            if($dailyUpdate === null){
                DailyUpdate::create([
                    "keyword" => $this->getKeyword($request->service_id),
                    "service" => $request->service_id,
                    "total_sms_sent" => 1,
                    "total_delivery" => 1
                ]);
            }else{
                DailyUpdate::where('id', $dailyUpdate->id)->update([
                    "total_sms_sent" => $dailyUpdate->total_sms_sent + 1,
                    "total_delivery"=> $dailyUpdate->total_delivery + 1,
                ]);
            }

            if($dailyBilled === null){
                DailyBilled::create([
                    "total_sms_sent" => $sentCount,
                    "total_delivery" => $deliveryCount,
                ]);
            }else{
                DailyBilled::where('id', $dailyBilled->id)->update([
                    "total_sms_sent" => $sentCount,
                    "total_delivery" => $deliveryCount,
                ]);
            }
        }                  
    }



    public function getKeyword($serviceId) {
        switch($serviceId) {
            case('9916110010'):
                $serviceName = "MOTIVATION";
                break;        
            case('9916110011'):
                $serviceName = "WISDOM";
                break;
            case('9916110009'):
                $serviceName = "HEALTHBOX";
                break;    
            case('9916110005'):
                $serviceName = "PRG";
                break;
            case('9916110008'):
                $serviceName = "MOVIES";
                break;
            case('9916110013'):
                $serviceName = "FINANCE";
                break; 
            case('9916110006'):
                $serviceName = "NEWS";
                break;  
            case('9916110022'):
                $serviceName = "CHELSEA";
                break;   
            case('9916110026'):
                $serviceName = "UNKNOWN";
                break; 
            case('963'):
                $serviceName = "LPOOL";
                break;  
            case('970'):
                $serviceName = "MANCITY";
                break; 
            case('979'):
                $serviceName = "CATHOLIC";
                break; 
            case('988'):
                $serviceName = "PPP";
                break; 
            case('989'):
                $serviceName = "PKN";
                break; 
            case('982'):
                $serviceName = "AG";
                break;
            case('987'):
                $serviceName = "FABU";
                break;
            case('980'):
                $serviceName = "GFA";
                break;  
            case('992'):
                $serviceName = "FAITHS";
                break;
            case('978'):
                $serviceName = "MONEY";
                break;
            case('990'):
                $serviceName = "CARE247";
                break;

            default:
                // $msg = 'Something went wrong.';
                $serviceName = "DEFAULT";
        }
        return $serviceName;
    }
}
