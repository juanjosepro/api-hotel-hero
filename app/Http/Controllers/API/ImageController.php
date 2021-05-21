<?php

namespace App\Http\Controllers\API;

use App\Models\Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //remove an image from any model
    public function removeAnImageFromGallery($id)
    {
        $image = Image::find($id);

        if (is_object($image)){
            if ($image->url != "public/without-image.jpg") {
                Storage::delete($image->url);
            }
            $image->delete();
            return response()->macroResponseJsonApi("image removed successfully", 200);
        }
        return response()->macroResponseJsonApi("resource not found", 404);

    }
}
