<?php

namespace App\Helpers;

use App\Country;
use App\Models\User;
use App\Models\Pic;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Image;

class Helpers {

    public static function generateKey(String $prefix){
        return $prefix.'-'.uniqid().'-'.uniqid().'-'.uniqid().'-'.uniqid();
    }

    public static function mediaProfileForeach($items, String $collection){
        foreach($items as $item){
            $item->getMedia($collection);
        }
    }

    public static function addMediaToModel($pic, $collection, $object){
        $collectionOriginal = $collection;
        $mediaItems = $object
        ->addMedia($pic)
        ->toMediaCollection($collection);
            $mediaItems->setCustomProperty('url', $mediaItems->getFullUrl());
            //$mediaItems->setCustomProperty('watermark', $mediaItems->getUrl('watermark'));
            $mediaItems->save();
            $object->medias()->save($mediaItems);
    }

}
