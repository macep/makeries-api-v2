<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $hidden = array('pivot');
    protected $table = 'medias';
    public $filterable= ['string'=>['name','url'],'integer'=>['maker_id']];
    /**
     * The makers that belong to.
     */
    public function makers()
    {
        return $this->belongsToMany('App\Maker');
    }

}