<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::latest("id")->get();

        if (empty($photos->toArray())) {
            return response()->json([
                "message" => "there is no photo"
            ]);
        }

        return PhotoResource::collection($photos);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoRequest $request)
    {
        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            $savedPhotos = [];
            foreach ($photos as $photo) {
                $fileSize = $photo->getSize();
                $name = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $savedPhoto = $photo->store("public/photo");
                $savedPhotos[] = [
                    "url" => $savedPhoto,
                    "name" => $name,
                    "ext" => $photo->extension(),
                    "user_id" => Auth::id(),
                    "size" => $this->formatBytes($fileSize),
                    "created_at" => now(),
                    "updated_at" => now()

                ];
            }
            Photo::insert($savedPhotos);
        }

        return response()->json([
            "message" => "uploaded photo successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $photo = Photo::find($id);
        if (is_null($photo)) {
            return response()->json([
                "message" => "there is no photo"
            ]);
        }
        return new PhotoResource($photo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photo::find($id);
        if (is_null($photo)) {
            return response()->json([
                "message" => "there is no photo"
            ]);
        }
        $photo->delete();
        Storage::delete($photo->url);
        return response()->json([
            "message" => "photo deleted successfully"
        ]);
    }
}
