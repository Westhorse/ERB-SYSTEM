<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

use App\Models\Image\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileUploadAction
{

    function str_random($length = 4)
    {
        return Str::random($length);
    }

    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }

    public function execute($model, $files, $destination)
    {
        foreach ($files as $images) {

            $img = "";
            $img = $this->str_random(4) . $images->getClientOriginalName();
            $originname = time() . '.' . $images->getClientOriginalName();
            $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
            $filename = $images->hashName();
            $extention = pathinfo($originname, PATHINFO_EXTENSION);
            $img = $filename;
            $type = $images->extension();
            $size = $images->getSize();
            $images->move(public_path('storage'), $img);
            $model->images()->create(['image' => $img, 'type' => $type, 'size' => $size]);
        }
    }

    public function executeBase64($model, $files, $destination=null)
    {
        foreach ($files as $file) {
            if (preg_match('/^data:image\/(\w+);base64,/', $file)) {
                $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                $replace = substr($file, 0, strpos($file, ',') + 1);
                $image = str_replace($replace, '', $file);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10) . '.' . $extension;
                Storage::disk('public')->put($imageName, base64_decode($image));
                $model->images()->create(['image' => $imageName, 'type' => $extension]);
            }
        }
    }
    public static function saveArrayOfBase64Images($imagesStrings)
    {
        $imagesPath = [];
        foreach ($imagesStrings as $imageString) {

            $path = '/' . Str::random(16) . '.jpg';
            $file = fopen('storage' . $path, 'wb');
            fwrite($file, base64_decode($imageString));
            fclose($file);
            $imagesPath[] = $path;
        }
        return $imagesPath;
    }
}
