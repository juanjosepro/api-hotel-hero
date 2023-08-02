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
        $totalAvailable = Room::where('status', 'disabled')->get();
        $totalOcupied = Room::where('status', 'occupied')->get();
        $totalCleaning = Room::where('status', 'cleaning')->get();
        $totalMaintenance = Room::where('status', 'maintenance')->get();
        $totalDisabled = Room::where('status', 'disabled')->get();
        $totalRooms = Room::count();

        $data = [
            ["total_rooms" => $totalRooms],
            ["available" => count($totalAvailable)],
            ["occupied" => count($totalOcupied)],
            ["cleaning" => count($totalCleaning)],
            ["maintenance" => count($totalMaintenance)],
            ["disabled" => count($totalDisabled)]
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
        $hotel = Reservation::where('via', 'hotel')->get();
        $web = Reservation::where('via', 'web')->get();
        $call = Reservation::where('via', 'call')->get();
        $whatsapp = Reservation::where('via', 'whatsapp')->get();
        $facebook = Reservation::where('via', 'facebook')->get();
        $other = Reservation::where('via', 'other')->get();

        $data = [
            ["hotel" => count($hotel)],
            ["web" => count($web)],
            ["call" => count($call)],
            ["whatsapp" => count($whatsapp)],
            ["facebook" => count($facebook)],
            ["other" => count($other)]
        ];

        return response()->json($data);
    }
}
