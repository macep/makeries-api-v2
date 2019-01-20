<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $hidden = array('pivot');
    public $filterable= ['string'=>['name']];

    public function getImageFilePath() {
        return storage_path() . '/images/' . ($this->id % 10) . '/'. $this->id;
        //return __DIR__ . '/../../../../storage/images/' . ($this->id % 10) . '/'. $this->id;
    }

    public function removeImageFile() {
        $imagePath = $this->getImageFilePath();
        //TODO: check if file not exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $imagePath .= '-thumb';
        //TODO: check if file not exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}