<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Room;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    public function index($status = "all")
    {
        //if status is empty return all rooms
        $rooms = "";

        if ($status === "all") {
            $rooms = Room::latest()->get();
        } else {
            $statusLowercase = strtolower($status);

            //valid parameter
            $listOfStatus = ["available", "occupied", "maintenance", "cleaning", "disabled"];

            //arrow functions exist as of version 7.4 of php
            $validParameter = array_filter($listOfStatus, fn ($s) => $s === $statusLowercase);

            if (count($validParameter)) {
                $rooms = Room::where("status", $statusLowercase)->latest()->get();
            } else {
                return response()->json([
                    "msg" => "parameter invalid"
                ], 404);
            }
        }

        if (count($rooms) > 0) {
            return ResourceCollection::make($rooms);
        }
        return response()->macroResponseJsonApi('no resources to show!', 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomRequest $request
     * @return ResourceObject
     */
    public function store(RoomRequest $request)
    {
        $room = Room::create([
            'category_id' => $request['category_id'],
            'number'      => $request['number'],
            'level'       => $request['level'],
            'location'    => $request['location'],
            //status by default "available" in bd but I want that field to me return
            'status'      => "available"
        ]);

        return ResourceObject::make($room);
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return ResourceObject
     */
    public function show(Room $room)
    {
        return ResourceObject::make($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoomRequest $request
     * @param Room $room
     * @return ResourceObject
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->category_id = $request['category_id'];
        $room->number = $request['number'];
        $room->level = $request['level'];
        $room->location = $request['location'];
        $room->status = $request['status'];
        $room->save();

        return ResourceObject::make($room);
    }
}
