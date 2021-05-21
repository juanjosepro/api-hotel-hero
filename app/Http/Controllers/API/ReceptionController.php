<?php

namespace App\Http\Controllers\API;

use App\Models\Box;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceObject;
use App\Http\Requests\ReceptionRequest;
use App\Http\Traits\CalculatePriceTrait;
use Illuminate\Http\Response;

class ReceptionController extends Controller
{
    use CalculatePriceTrait;
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $categories = Category::select(["id", "name", "price"])->get();
        $rooms = Room::select(["id", "category_id", "number", "level", "location", "status"])->get();

        if (count($categories) === 0 || count($rooms) === 0) {
            return response()
            ->macroResponseJsonApi("no resources to show", 204);
        }

        $data = [];

        foreach ($categories as $category) {
            $items = [];
            foreach ($rooms as $room) {
                if ($category->id == $room->category_id) {
                    $room->price = $category->price;
                    $items[] = $room;
                }
            }
            $data[] = ["tab" => $category, "content" => $items];
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReceptionRequest $request
     * @return Response
     */
    public function registerANewGuestThroughTheReception(ReceptionRequest $request)
    {
        //change 2021-04-09 21:06:53 to 2021-04-09 21:06:00
        $changeSecondsEntry = substr($request["entry_date"], 0, 17);
        $entry_date = $changeSecondsEntry."00";

        $guest = new Guest();
        $guest = $this->addTheDataToItsProperties($guest, $request);
        $guest->entry_date = $entry_date;
        //status by default hosped
        //email and via(hotel, web, call...) only for reservations outside the hotel.
        $guest->save();

        //It is necessary to access the first index with (first) since it returns it in an array.
        $room = Room::where("number", $request["room_number"])->get()->first();
        $room->status = "occupied";
        $room->save();

        $total = $this->calculatePrice($guest->entry_date, $guest->departure_date, $room->category->price);

        $box = new Box();
        $box->guest_id = $guest->id;
        $box->amount = $total;
        $box->save();

        return response()->macroResponseJsonApi("guest hosped successfully", 200);
    }

    /**
     * Returns the data of the guest and the data of the occupied room
     *
     * @param int $number
     * @return ResourceObject
     */
    public function showGuestData(int $number)
    {
        $guest = Guest::where("room_number", $number)
            ->where("status", "hosped")
            ->get()
            ->first();

        if (is_object($guest)) return ResourceObject::make($guest);

        return response()->macroResponseJsonApi(
            'no guest was found currently staying in this room number',
            404
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReceptionRequest $request
     * @param int $id
     * @return Response
     */
    public function updateAGuestHostedThroughTheReception(ReceptionRequest $request, int $id)
    {
        $guest = Guest::find($id);

        if (is_object($guest)) {
            $guest = $this->addTheDataToItsProperties($guest, $request);
            $guest->save();

            $total = $this->calculatePrice($guest->entry_date, $guest->departure_date, $guest->room->category->price);

            $box = Box::where("guest_id", $guest->id)->get()->first();
            $box->amount = $total;
            $box->save();

            return response()->macroResponseJsonApi("guest update successfully", 200);
        }

        return response()->macroResponseJsonApi("guest not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function removeAGuestAndFreeTheRoom(int $id)
    {
        $guest = Guest::where("id", $id)->where("status", "hosped")->get()->first();

        if (is_object($guest)) {
            $guest->status = "retired";
            $guest->save();

            $guest->room->status = "cleaning";
            $guest->room->save();

            return response()->macroResponseJsonApi(
                "guest retired successfully and freed room!",
                200
            );
        }

        return response()->macroResponseJsonApi("guest not found", 404);
    }

    public function addTheDataToItsProperties ($model, $request)
    {
        $changeSecondsDeparture = substr($request["departure_date"], 0, 17);
        $departure_date = $changeSecondsDeparture."00";

        $model->room_number = $request["room_number"];
        $model->name = strtolower($request["name"]);
        $model->last_name = strtolower($request["last_name"]);
        $model->dni = $request["dni"];
        $model->persons = $request["persons"];
        $model->origin = strtolower($request["origin"]);
        $model->departure_date = $departure_date;

        //If any of the fields are not empty, adds its value to your property
        if (!empty($request["phone"])) $model->phone = $request["phone"];
        if (!empty($request["email"])) $model->email = strtolower($request["email"]);
        if (!empty($request["message"])) $model->message = strtolower($request["message"]);
        //status, via(hotel, web, call...) and entry_date they cannot be modified.
        return $model;
    }
}
