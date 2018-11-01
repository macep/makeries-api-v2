<?php

namespace App;
use App\Logging;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MakerGroup extends Model
{
    //
    protected $table = 'maker_groups';
    protected $hidden = array('pivot');
    public $filterable= ['string'=>['name']];

    public function businesstypes()
    {
        return $this->belongsToMany('App\BusinessType', 'maker_group_business_type')
                ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')
                ->withTimestamps();
    }

    public function regions()
    {
        return $this->belongsToMany('App\Region')
                ->withTimestamps();
    }

    public function servicetypes()
    {
        return $this->belongsToMany('App\ServiceType')
                ->as('service_types')
                ->withTimestamps();
    }

    /**
     * The makers that belong to.
     */
    public function makers()
    {
        #return $this->belongsToMany('App\Product');
    }

    public function insertObject($request) {
        $this->name = $request->name;
        $this->created_by = $request->auth->userId;
        return $this->setObject($request, $request->auth->userId);
    }

    public function updateObject($request) {
        $this->name = $request->name;
        $this->updated_by = $request->auth->userId;
        if ($request->has('regions') && strlen($request->regions)) {
            DB::table('maker_group_region')->where('maker_group_id', $this->id)->delete();
        }
        if ($request->has('products') && strlen($request->products)) {
            DB::table('maker_group_product')->where('maker_group_id', $this->id)->delete();
        }
        if ($request->has('business_types') && strlen($request->business_types)) {
            DB::table('maker_group_business_type')->where('maker_group_id', $this->id)->delete();
        }
        if ($request->has('service_types') && strlen($request->service_types)) {
            DB::table('maker_group_service_type')->where('maker_group_id', $this->id)->delete();
        }
        return $this->setObject($request, $request->auth->userId);
    }

    private function setObject($request, $userId) {
        try{
            DB::beginTransaction();
            $this->save();
            try {
                if ($request->has('business_types')) {
                    $tabBusinessTypes = explode(',',$request->business_types);
                    foreach ($tabBusinessTypes as $businessTypeId) {
                        $this->businesstypes()->attach($businessTypeId, ['created_by' => $userId]);
                    }
                }
                if ($request->has('products')) {
                    $tabProducts = explode(',',$request->products);
                    foreach ($tabProducts as $productId) {
                        $this->products()->attach($productId, ['created_by' => $userId]);
                    }
                }
                 if ($request->has('regions')) {
                    $tabRegions = explode(',',$request->regions);
                    foreach ($tabRegions as $regionId) {
                        $this->regions()->attach($regionId, ['created_by' => $userId]);
                    }
                }
                if ($request->has('service_types')) {
                    $tabServiceTypes = explode(',',$request->service_types);
                    foreach ($tabServiceTypes as $serviceTypeId) {
                        $this->servicetypes()->attach($serviceTypeId, ['created_by' => $userId]);
                    }
                }
            } catch(\Illuminate\Database\QueryException $ex){
                $message = $ex->getMessage();
                if (strpos('constraint violation', $message)) {
                    $returnMsg = 'Integrity constraint violation';
                } else {
                    $returnMsg = 'Entity setting up failed';
                }
            $logging = new Logging();
            $logging->info($request, 'MAKER_GROUP:SAVE',[$ex->getMessage()]);
                //TODO: clear  updated object
                return $returnMsg;
            }
            DB::commit();
        }catch(\Exception $e){
            $logging = new Logging();
            $logging->info($request, 'MAKER_GROUP:SAVE',[$e->getMessage()]);
            DB::rollback();
            return false;
        }
        return true;
    }

}