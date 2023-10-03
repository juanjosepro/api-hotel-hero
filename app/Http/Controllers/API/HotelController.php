<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\HotelRequest;
use App\Http\Resources\ResourceObject;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
      $hotel = Hotel::first();

      if (is_object($hotel)) {
        return ResourceObject::make($hotel);
      }

      return response()->macroResponseJsonApi("no resource to show", 204);
    }

    public function update(HotelRequest $request, Hotel $hotel)
    {
        $hotel->name = $request["name"];
        if (!empty($request["ruc"])) $hotel->ruc = $request["ruc"];
        if (!empty($request["location"])) $hotel->location = $request["location"];
        if (!empty($request["phone"])) $hotel->phone = $request["phone"];
        if (!empty($request["email"])) $hotel->email = $request["email"];
        $hotel->levels = $request["levels"];
        if (!empty($request["description"])) $hotel->description = $request["description"];

        if ($request->hasFile("image")) {
          if ($hotel->image !== "public/without-image.png") {
            Storage::delete($hotel->image);
          }

          $path = $request->file("image")->store("public/hotel");
          $hotel->image = $path;
        }

        if ($request->hasFile("logo")) {

          if ($hotel->logo !== "public/without-image.png") {
            Storage::delete($hotel->logo);
          }

          $path = $request->file("logo")->store("public/hotel");
          $hotel->logo = $path;
        }

        $hotel->save();

        return ResourceObject::make($hotel);
    }
}
