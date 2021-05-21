<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Box;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BoxController extends Controller
{
    public function index()
    {
        $box = Box::select(
            DB::raw("SUM(amount) as amount"),
            DB::raw("DATE(created_at) as date")
        )->groupBy("date")
        ->get();

        return $box;
    }

    public function dailyCheck()
    {
        $resultboxToday = (object)[];
        $resultboxTotal = (object)[];

        $boxToday = Box::select(
            DB::raw("COALESCE(SUM(amount), 0) as amount"),
            DB::raw("DATE(created_at) as date")
        )->groupBy("date")
        ->where(DB::raw("Date(created_at)"), "=", date("Y/m/d"))
        ->get();

        //extract the array
        foreach ($boxToday as $key) {
            $resultboxToday = $key;
        }

        $boxTotal = Box::select(
            DB::raw("COALESCE(SUM(amount), 0) as amount"))->get();

        foreach ($boxTotal as $key) {
            $resultboxTotal = $key;
        }

        if (count((array) $resultboxToday)){
            //for readability ... optional
            $resultboxToday->totaldailyamount = $resultboxToday->amount;
            unset($resultboxToday->amount);
        }else{
            $resultboxToday->date = date("Y-m-d");
            $resultboxToday->totaldailyamount = "0.00";
        }

        //for readability ... optional
        $resultboxTotal->totalamount = $resultboxTotal->amount;
        unset($resultboxTotal->amount);

        return response()->json([
            "boxToday" => $resultboxToday,
            "boxTotal" => $resultboxTotal
        ], 200);
    }

    public function cashDetailsByDate($date)
    {
        if (strlen($date) !== 10){
            return response()->macroResponseJsonApi(
                "Parameter invalid!.. the parameter must be example '2021-04-15'",
                400
            );
        }

        $from = $date." 00:00:00";
        $to = $date." 23:59:59";
        $cashDetails = Box::whereBetween("created_at", [$from, $to])->get();

        if(count($cashDetails) == 0) {
            return response()->macroResponseJsonApi(
                "No resources to show",
                404
            );
        }

        $result = [];

        foreach ($cashDetails as $key) {
            //warning with hours, minutes or seconds
            //only calculate days but not hours ... refactor
            $fechaEmision = Carbon::parse($key->guest->entry_date);
            $fechaExpiracion = Carbon::parse($key->guest->departure_date);
            $dias = $fechaExpiracion->diffInDays($fechaEmision);

            $key->days = $dias;
            $key->guest->room->category;
            $result[] = $key;
        }

        return $result;
    }
}
