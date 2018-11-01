<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    //
    protected $table = 'business_types';
    protected $hidden = array('pivot');
    public $filterable= ['string'=>['name']];

}