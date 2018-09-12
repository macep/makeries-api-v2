<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $hidden = array('pivot');
    public $filterable= ['string'=>['name', 'description'],'number'=>['maker_id']];

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function makers()
    {
        return $this->belongsToMany('App\Maker');
    }

}