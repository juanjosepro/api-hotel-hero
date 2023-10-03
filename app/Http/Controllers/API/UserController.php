<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    /* status = enabled OR disabled */
    public function index($status = "enabled")
    {
        $statusLowercase = strtolower($status);

        if ($statusLowercase != "enabled" && $statusLowercase != "disabled" && $statusLowercase != "all") {
            return response()->macroResponseJsonApi('parameter invalid!', 404);
        }

        if($statusLowercase === 'all') {
            $users = User::latest()->get();
        } else {
            $users = User::where("status", $statusLowercase)->latest()->get();
        }

        if (count($users) > 0) {
            return ResourceCollection::make($users);
        }

        return response()
            ->macroResponseJsonApi("no resources to show", 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return ResourceObject
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->role_id = $request["role_id"];
        $user->name = strtolower($request["name"]);
        $user->last_name = strtolower($request["last_name"]);
        $user->dni = $request["dni"];
        $user->date_of_birth = $request["date_of_birth"];
        $user->password = bcrypt($request["password"]);

        if (!empty($request["phone"])) $user->phone = strtolower($request["phone"]);
        if (!empty($request["email"])) $user->email = strtolower($request["email"]);
        //status enabled by default.
        $user->save();

        if ($request->hasFile("image")) {
            $path = $request->file("image")->store("public/users");
            $user->image()->update(["url" => $path]);
        } else {
            $user->image()->create(["url" => "public/without-image.png"]);
        }

        return ResourceObject::make($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return ResourceObject
     */
    public function show(User $user)
    {
        return ResourceObject::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return ResourceObject
     */
    public function update(UserRequest $request, User $user)
    {
        $user->role_id = $request["role_id"];
        $user->name = strtolower($request["name"]);
        $user->last_name = strtolower($request["last_name"]);
        $user->dni = $request["dni"];
        $user->date_of_birth = $request["date_of_birth"];
        $user->status = $request["status"];

        if (!empty($request["phone"])) $user->phone = strtolower($request["phone"]);
        if (!empty($request["email"])) $user->email = strtolower($request["email"]);

        if ($request->hasFile("image")) {
            Storage::delete($user->image->url);

            $path = $request->file("image")->store("public/users");
            $user->image()->update(["url" => $path]);
        }

        if ($user->save()) {
            return ResourceObject::make($user);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $status = $user->status !== "enabled" ? "enabled" : "disabled";
        $user->status = $status;
        $user->save();

        return response()->macroResponseJsonApi("user $status successfully", 200);
    }
}
