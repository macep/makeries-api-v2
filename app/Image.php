<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $hidden = array('pivot');
    public $filterable= ['string'=>['name']];

}