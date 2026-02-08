<?php

namespace App\Helpers;

use App\Country;
use App\Models\User;
use App\Models\Pic;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Helpers {

    public static function generateKey(String $prefix){
        return $prefix.'-'.uniqid().'-'.uniqid().'-'.uniqid().'-'.uniqid();
    }

    public static function mediaProfileForeach($items, String $collection){
        foreach($items as $item){
            $item->getMedia($collection);
        }
    }

/*     public static function addMediaToModel($pic, $collection, $object){
         $collectionOriginal = $collection;
        $mediaItems = $object
        ->addMedia($pic)
        ->toMediaCollection($collection);
            $mediaItems->setCustomProperty('url', $mediaItems->getFullUrl());
            //$mediaItems->setCustomProperty('watermark', $mediaItems->getUrl('watermark'));
            $mediaItems->save();
            $object->medias()->save($mediaItems);
    } */

    public static function addMediaToModel(
        $pic,
        string $collection,
        $object,
        int $maxWidth = 1920,
        int $maxHeight = 1920
    ): ?Media {
        if (!$object || !method_exists($object, 'addMedia')) {
            Log::warning("Le modèle ne supporte pas les médias Spatie");
            return null;
        }

        try {
            // Étape 1 : Pré-traitement de l'image AVANT d'ajouter à Media Library
            $fileToAdd = $pic;

            if ($pic instanceof UploadedFile) {
                // Créer un chemin temporaire pour travailler sur une copie
                $tempPath = $pic->getRealPath();

                // Charger et optimiser/redimensionner l'original
                Image::load($tempPath)
                    ->fit(Manipulations::FIT_MAX, $maxWidth, $maxHeight) // conserve proportions, pas d'upscale
                    ->optimize()                                           // compresse (jpegoptim, pngquant, etc.)
                    ->save($tempPath);                                     // écrase le temporaire

                $fileToAdd = $pic; // on réutilise le fichier modifié
            }

            // Étape 2 : Ajout à la Media Library
            $media = $object
                ->addMedia($fileToAdd)
                ->toMediaCollection($collection);

            // Étape 3 : Ajout de propriétés utiles
            $media->setCustomProperty('url', $media->getFullUrl());
            // $media->setCustomProperty('url_small', $media->getUrl('small')); // si tu as une conversion 'small'
            // $media->setCustomProperty('watermark', $media->getUrl('watermark'));

            $media->save();

            // Si tu as une relation pivot medias() personnalisée
            if (method_exists($object, 'medias')) {
                $object->medias()->save($media);
            }

            return $media;

        } catch (\Exception $e) {
            Log::error("Erreur lors de l'ajout du média : " . $e->getMessage());
            return null;
        }
    }

}
