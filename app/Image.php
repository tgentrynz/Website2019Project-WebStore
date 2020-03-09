<?php

namespace App;

use ImageLib;
use Illuminate\Support\Facades\Storage;
/**
 * Helper class for images
*/
class Image
{
    //
    const IMAGE_PATH = "storage/image/";
    const PUBLIC_IMAGE_PATH = "public/image/";
    const DEFAULT_IMAGE = self::IMAGE_PATH . "default";

    private $img;

    function __construct($file)
    {
        $this->img = ImageLib::make($file->getRealPath());
    }

    public function Store()
    {
        $id = uniqid();
        while(!self::IDIsUnique($id)){
            $id = uniqid();
        }
        $this->img->save(public_path(self::IMAGE_PATH) . $id);
        return $id;
    }

    public function Resize($x, $y)
    {
        $this->img->resize($x, $y);
    }

    public static function GetImage($id)
    {
        $exists = Storage::disk('local')->exists(self::PUBLIC_IMAGE_PATH . $id) && !is_null($id);
        return $exists ? Storage::url(self::PUBLIC_IMAGE_PATH . $id) : Storage::url(self::PUBLIC_IMAGE_PATH . "default") ;
    }

    public static function RemoveImage($id)
    {
        Storage::disk('local')->delete(self::PUBLIC_IMAGE_PATH . $id);
        //Storage::delete(self::IMAGE_PATH . $id);
    }

    public static function IDIsUnique($id)
    {
        return !(Storage::disk('local')->exists(public_path(self::IMAGE_PATH) . $id));
    }
}
