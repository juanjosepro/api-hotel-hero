<?php

namespace App\Http\Controllers\API;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceObject;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ResourceCollection;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $reservations = Reservation::latest()->get();

        if (count($reservations) > 0) {
            return ResourceCollection::make($reservations);
        }

        return response()->macroResponseJsonApi("no resources to show", 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReservationRequest $request
     * @return Response
     */
    public function store(ReservationRequest $request)
    {
        $reservation = new Reservation();
        //If any of the fields are not empty, adds its value to your property
        $reservation = $this->addTheDataToItsProperties($reservation, $request);

        $reservation->save();

        return response()
        ->macroResponseJsonApi("reservation register successfully", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ResourceObject
     */
    public function show(int $id)
    {
        $reservation = Reservation::find($id);

        if(is_object($reservation)){
            return ResourceObject::make($reservation);
        }

        return response()
        ->macroResponseJsonApi("resource not found", 204);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReservationRequest $request
     * @param int $id
     * @return ResourceObject
     */
    public function update(ReservationRequest $request, int $id)
    {
        $reservation = Reservation::find($id);

        if(is_object($reservation)){
            $reservation = $this->addTheDataToItsProperties($reservation, $request);
            $reservation->save();

            return ResourceObject::make($reservation);
        }

        return response()
        ->macroResponseJsonApi("resource not found", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $reservation = Reservation::find($id);
        if(is_object($reservation)){
            $reservation->delete();
            return response()->macroResponseJsonApi("reservation deleted successfully", 200);
        }

        return response()
        ->macroResponseJsonApi("resource not found", 204);
    }

    public function addTheDataToItsProperties ($model, $request)
    {
        //change 2021-04-09 21:06:53 to 2021-04-09 21:06:00
        $changeSecondsEntry = substr($request["entry_date"], 0, 17);
        $entryDate = $changeSecondsEntry."00";
        $changeSecondsDeparture = substr($request["departure_date"], 0, 17);
        $departureDate = $changeSecondsDeparture."00";

        $model->room_number = $request["room_number"];
        $model->via = strtolower($request["via"]);
        $model->persons = $request["persons"];
        $model->name = strtolower($request["name"]);
        $model->last_name = strtolower($request["last_name"]);
        $model->entry_date = $entryDate;
        $model->departure_date = $departureDate;

        //If any of the fields are not empty, adds its value to your property
        if (!empty($request["dni"])) $model->dni = $request["dni"];
        if (!empty($request["phone"])) $model->phone = $request["phone"];
        if (!empty($request["email"])) $model->email = strtolower($request["email"]);
        if (!empty($request["origin"])) $model->origin = strtolower($request["origin"]);
        if (!empty($request["message"])) $model->message = strtolower($request["message"]);

        return $model;
    }
}
