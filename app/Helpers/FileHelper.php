<?php


namespace App\Helpers;


use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function uploadFiles($files, $path)
    {
        $filesArray = array();
        try {
            if (isset($files) && is_array($files))
                foreach ($files as $file) {
                    $filename = $file->store($path, 'public');
                    // $filename = asset('storage/'.$filename);
                    array_push($filesArray, $filename);
                }
        } catch (\Exception $ex) {
            return false;
        }
        return $filesArray;
    }

    public static function removeFiles($images_paths)
    {
        foreach ($images_paths as $image) {
            Storage::disk('public')->delete($image);
        }
    }

    public static function getFiles($directory_path)
    {
        return Storage::disk('public')->files($directory_path);
    }

    public static function getAllFiles($directory_path)
    {
        return Storage::disk('public')->allFiles($directory_path);
    }
}