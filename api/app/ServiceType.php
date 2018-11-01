<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    //
    protected $table = 'service_types';
    protected $hidden = array('pivot');
    public $filterable= ['string'=>['name']];

    /**
     * The makers that belong to.
     */
    public function makers()
    {
        return $this->belongsToMany('App\Product');
    }

}