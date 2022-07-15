<?php

namespace App\Services;

use File;
use Image;

class ImageService
{
    public static function save($image, $dir , $resize = null)
    {
        $name_origin = explode('.', $image->getClientOriginalName());
        $image_name =  hrtime(true) . '.' . end($name_origin);
        $file_path = $dir . $image_name;

        if (!File::exists($dir)) {
            File::makeDirectory($dir, $mode = 0777, true, true);
        }
        Image::make($image)->save(($file_path));

        if (!empty($resize)){
            $config = null ;//?? Setting::select('thumb_width', 'thumb_height')->first();
            $width = 300 ?? $config->thumb_width;
            $height = 300 ?? $config->thumb_height;
            $name_resize = $width.'x'.$height.'_' . $image_name;
            $file_path_resize = $dir . $name_resize;
            $background = Image::canvas($width, $height);
            $img_resize =  Image::make($image)->resize($width, $height , function ($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $background->insert($img_resize, 'center');
            $background->save($file_path_resize);
            return [$file_path, $file_path_resize];
        }
        return $file_path;
    }
}
