<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function getMostUsedRooms()
    {
        $query = Guest::join('rooms', 'rooms.number', '=', 'guests.room_number')
            ->join('categories', 'categories.id', '=', 'rooms.category_id')
            ->select(DB::raw('count(rooms.category_id) as most_used, categories.name'))
            ->groupBy('rooms.category_id', 'categories.name')
            ->get();
        return $query;
    }

    public function getRoomStatus()
    {
        $totalAvailable = Room::select(DB::raw('count(status)'))->where('status', 'available')->first();
        $totalOcupied = Room::select(DB::raw('count(status)'))->where('status', 'occupied')->first();
        $totalCleaning = Room::select(DB::raw('count(status)'))->where('status', 'cleaning')->first();
        $totalMaintenance = Room::select(DB::raw('count(status)'))->where('status', 'maintenance')->first();
        $totalDisabled = Room::select(DB::raw('count(status)'))->where('status', 'disabled')->first();
        $totalRooms = Room::count();

        $data = [
            ["name" => "total_rooms", "count" => $totalRooms],
            ["name" => "total_available", "count" => $totalAvailable->count],
            ["name" => "total_ocupied'", "count" => $totalOcupied->count],
            ["name" => "total_cleaning", "count" => $totalCleaning->count],
            ["name" => "total_maintenance", "count" => $totalMaintenance->count],
            ["name" => "total_disabled", "count" => $totalDisabled->count]
        ];
        return response()->json($data);
    }

    public function getASumOfMoneyPerMonth()
    {
        $query = Box::select(
            DB::raw('sum(amount) as amount'),
            DB::raw('DATE(created_at) as date')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        return $query;
    }

    public function getTheMostUsedMeansForReservations(){
        $hotel = Reservation::select(DB::raw('count(via)'))->where('via', 'hotel')->first();
        $web = Reservation::select(DB::raw('count(via)'))->where('via', 'web')->first();
        $call = Reservation::select(DB::raw('count(via)'))->where('via', 'call')->first();
        $whatsapp = Reservation::select(DB::raw('count(via)'))->where('via', 'whatsapp')->first();
        $facebook = Reservation::select(DB::raw('count(via)'))->where('via', 'facebook')->first();
        $other = Reservation::select(DB::raw('count(via)'))->where('via', 'other')->first();

        $data = [
            ["name" => "hotel", "count" => $hotel->count > 0 ? $hotel->count : 0],
            ["name" => "web", "count" => $web->count > 0 ? $web->count : 0],
            ["name" => "call'", "count" => $call->count > 0 ? $call->count : 0],
            ["name" => "whatsapp", "count" => $whatsapp->count > 0 ? $whatsapp->count : 0],
            ["name" => "facebook", "count" => $facebook->count > 0 ? $facebook->count : 0],
            ["name" => "other", "count" => $other->count > 0 ? $other->count : 0]
        ];

        return response()->json($data);
    }
}
