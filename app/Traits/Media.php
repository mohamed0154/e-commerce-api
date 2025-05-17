<?php

namespace App\Traits;

trait Media
{
    public function uploadPhoto($photo, $path)
    {
        $photoName = uniqid() . '.' . $photo->extension();
        $photo->move(public_path($path), $photoName);
        return url("$path/") . '/' . $photoName;
    }


    public function deletePhoto($image){
        
        if(file_exists($image)){
            unlink($image);
        }
        
        return;
    }
}
