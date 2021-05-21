<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceObject;
use App\Http\Resources\ResourceCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $roles = Role::latest()->get();

        if (count($roles) > 0) {
            return ResourceCollection::make($roles);
        }

        return response()->macroResponseJsonApi("no resources to show", 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return ResourceObject
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create([
            "name" => strtolower($request["name"]),
            "description" => strtolower($request["description"])
        ]);

        return ResourceObject::make($role);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return ResourceObject
     */
    public function show(Role $role)
    {
        return ResourceObject::make($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return ResourceObject
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->name = strtolower($request["name"]);
        $role->description = strtolower($request["description"]);
        $role->save();

        return ResourceObject::make($role);
    }
}
