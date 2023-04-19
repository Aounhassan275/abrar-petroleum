<?php

namespace App\Helpers;

class FileHelper
{
    public static function saveFile($file,$path){
        $filename = $file->getClientOriginalName();
        $Path = public_path().$path;
        $file->move($Path, $filename);
        return $path.$filename;
    } 
    
}