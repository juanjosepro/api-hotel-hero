<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GuestController extends Controller
{
    public function index($status = "all")
    {
        $guests = "";

        if ($status === "all") {
            $guests = Guest::latest()->get();
        } else {
            $statusLowercase = strtolower($status);

            //valid parameter
            $listOfStatus = ["hosped", "retired"];

            //arrow functions exist as of version 7.4 of php
            // $validParameter = array_filter($listOfStatus, fn ($s) => $s === $statusLowercase);
            $validParameter = array_filter($listOfStatus, function($s, $statusLowercase){
                return $s === $statusLowercase;
            });

            //error de variable global $statusLowercase
            /*$validParameter = array_filter($listOfStatus, function ($s) {
                return  $s === $statusLowercase;
            });*/


            if (count($validParameter)) {
                $guests = Guest::where("status", $statusLowercase)->get();
            }
        }

        if (count($guests) > 0) {
            return ResourceCollection::make($guests);
        }

        return response()->json([
           "msg" => "no resource to show"
        ], 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Guest $guest
     * @return ResourceObject
     */
    public function show(Guest $guest)
    {
        return ResourceObject::make($guest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Guest $guest
     * @return Response
     */
    public function update(Request $request, Guest $guest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Guest $guest
     * @return Response
     */
    public function destroy(Guest $guest)
    {
        //
    }
}
