<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $categories = Category::latest()->get();

        if (count($categories) > 0) {
            return ResourceCollection::make($categories);
        }

        return response()->macroResponseJsonApi("no resources to show", 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return ResourceObject
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => strtolower($request['name'])
        ]);

        //image by default
        $category->image()->create(["url" => "public/without-image.jpg"]);

        return ResourceObject::make($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return ResourceObject
     */
    public function show(Category $category)
    {
        return ResourceObject::make($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     *
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $price = str_replace(',','',$request["price"]);
        $category->name = strtolower($request["name"]);
        $category->price = $price;
        $category->details = strtolower($request["details"]);

        if ($request->hasFile("images")) {
            if ($category->image->url == "public/without-image.jpg") {
                $category->image->delete();
            }

           $images = $request->file("images");

            foreach ($images as $image) {
                $path = $image->store("public/categories");
                $category->image()->create(["url" => $path]);
            }
        }

        $category->save();

        return ResourceObject::make($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        if (count($category->images) > 1) {
            foreach ($category->images as $image) {
                if ($image->url != "public/without-image.jpg") {
                    Storage::delete($image->url);
                }
                $image->delete();
            }
        }else{
            if ($category->image->url != "public/without-image.jpg") {
                Storage::delete($category->image->url);
            }
            $category->image->delete();
        }

        return response()->macroResponseJsonApi(
            "category deleted successfully",
            200
        );
    }

    public function getAllRoomsByCategory(Category $category)
    {
        $category->rooms;
        return $category;
    }
}
