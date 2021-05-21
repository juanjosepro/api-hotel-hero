<?php

namespace App\Http\Controllers;

use App\Http\Traits\CalculatePriceTrait;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\Guest;
use App\Models\Room;

class PDFController extends Controller
{
    use  CalculatePriceTrait;

    public function generatePDF($number)
    {
        if ($this->doesTheRoomExist($number)) {
            $hotel = Hotel::first();
            $data = Guest::join('boxes', 'boxes.guest_id', 'guests.id')
                ->join('rooms', 'rooms.number', 'guests.room_number')
                ->join('categories', 'categories.id', 'rooms.category_id')
                ->select(
                    'boxes.id AS id_box',
                    'guests.name AS name_guest',
                    'guests.last_name',
                    'guests.dni',
                    'guests.email AS email_guest',
                    'guests.phone AS phone_guest',
                    'guests.persons',
                    'guests.origin',
                    'guests.entry_date',
                    'guests.departure_date',
                    'guests.status AS status_guest',
                    'rooms.id AS id_room',
                    'rooms.number',
                    'rooms.level',
                    'rooms.status AS status_room',
                    'categories.name AS name_category',
                    'categories.price',
                    'categories.details',
                )
                ->where('rooms.number', $number)
                ->where('rooms.status', 'occupied')
                ->get()
                ->first();

            if ($data) {
                    $total = $this->calculatePrice($data->entry_date, $data->departure_date, $data->price);
                    $total = number_format($total, 2);
                    //return view('pdf', compact('room', 'dias', 'hotel'));
                    $pdf = PDF::loadView('pdf', compact('data', 'hotel', 'total'));
                    $pdf->getDomPDF()->setHttpContext(
                        stream_context_create([
                            'ssl' => [
                                'allow_self_signed'=> TRUE,
                                'verify_peer' => FALSE,
                                'verify_peer_name' => FALSE,
                            ]
                        ])
                    );
                    return $pdf->stream();
                }

            return response()->macroResponseJsonApi(
                "this room has the status available, a room with occupied status is required",
                404
            );
        }
        return response()->macroResponseJsonApi("resource not found", 404);
    }

    public function doesTheRoomExist($number): bool
    {
        $room = Room::where('rooms.number', $number)->first();
        return (bool)$room;
    }
}
