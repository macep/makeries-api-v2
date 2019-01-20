<?php

namespace App;
use App\Logging;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Maker extends Model
{
    public $filterable= [
        'string'=>[
            'name', 'address1', 'address2', 'city', 'postcode', 'email', 'telephone','website',
            'social1', 'social2', 'social3', 'map_url', 'admin_email', 'brief_description', 'long_description',
            'published', 'featured', 'subscription'
        ],
        'number'=>[
            'region.id', 'business_type.id', 'service_type.id', 'product.id', 'project.id', 'media.id'
        ]
    ];
    
    public function businesstypes()
    {
        return $this->belongsToMany('App\BusinessType', 'maker_business_type')
                ->as('business_types')
                ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function makergroups()
    {
        return $this->belongsToMany('App\MakerGroup', 'maker_maker_group')
                ->as('maker_groups')
                ->withTimestamps();
    }

    public function medias()
    {
        return $this->hasMany('App\Media');
        //return $this->belongsToMany('App\Media')->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }
    
    public function projects()
    {
        return $this->belongsToMany('App\Project')->withTimestamps();
    }

    public function regions()
    {
        return $this->belongsToMany('App\Region')->withTimestamps();
    }

    public function servicetypes()
    {
        return $this->belongsToMany('App\ServiceType')->withTimestamps();
    }

    public function insertObject($request) {
        $input = (object)$request->json()->all();
        if (!isset($input->name) || strlen(trim($input->name))==0) {
            return 'Name required';
        }
        $this->created_by = $request->auth->userId;
        return $this->setObject($request, $input, $request->auth->userId);
    }

    public function updateObject($request) {
        $input = (object)$request->json()->all();
        if (!isset($input->name) || strlen(trim($input->name))==0) {
            return 'Name required';
        }
        $this->updated_by = $request->auth->userId;
        DB::table('maker_region')->where('maker_id', $this->id)->delete();
        DB::table('maker_product')->where('maker_id', $this->id)->delete();
        DB::table('maker_business_type')->where('maker_id', $this->id)->delete();
        DB::table('maker_service_type')->where('maker_id', $this->id)->delete();
        if (isset($input->maker_groups)) {
            DB::table('maker_maker_group')->where('maker_id', $this->id)->delete();
        }
        //DB::table('maker_project')->where('maker_id', $this->id)->delete();
        //DB::table('maker_media')->where('maker_id', $this->id)->delete();
        return $this->setObject($request, $input, $request->auth->userId);
    }

    private function setObject($request, $input, $userId) {
        $fields = ['string'=>[
                                'name',
                                'address1',
                                'address2',
                                'city',
                                'postcode',
                                'admin_email',
                                'email',
                                'telephone',
                                'website',
                                'social1',
                                'social2',
                                'social3',
                                'map_url',
                                'brief_description',
                                'long_description'
                             ],
                   'enum'=>['list'=>[
                                'published',
                                'featured',
                                'subscription'
                                ],
                            'accepted' => ['yes', 'no']
                           ]
                   ];
        foreach ($fields as $type=>$data) {
            switch ($type) {
                case 'string':
                    foreach ($data as $field) {
                        if (isset($input->$field) && strlen(trim($input->$field))) {
                            $this->$field = $input->$field;
                        }
                    }
                    break;
                case 'enum':
                    foreach ($data['list'] as $field) {
                        if (isset($input->$field)) {
                            if (in_array($input->$field, $data['accepted'])) {
                                $this->$field = $input->$field;
                            } else {
                                return $field.' not in accepted values:'.json_encode($data['accepted']);
                            }
                        }
                    }
                    break;
            }
        }

        try{
            DB::beginTransaction();
            $this->save();
            try {
                if (isset($input->business_types)) {
                    $tabBusinessTypes = explode(',',$input->business_types);
                    foreach ($tabBusinessTypes as $businessTypeId) {
                        if ((int)$businessTypeId) {
                            $this->businesstypes()->attach($businessTypeId, ['created_by' => $userId]);
                        }
                    }
                }
                if (isset($input->products)) {
                    $tabProducts = explode(',',$input->products);
                    foreach ($tabProducts as $productId) {
                        if ((int)$productId) {
                            $this->products()->attach($productId, ['created_by' => $userId]);
                        }
                    }
                }
                 if (isset($input->regions)) {
                    $tabRegions = explode(',',$input->regions);
                    foreach ($tabRegions as $regionId) {
                        if ((int)$regionId) {
                            $this->regions()->attach((int)$regionId, ['created_by' => $userId]);
                        }
                    }
                }
                if (isset($input->service_types)) {
                    $tabServiceTypes = explode(',',$input->service_types);
                    foreach ($tabServiceTypes as $serviceTypeId) {
                        if ((int)$serviceTypeId) {
                            $this->servicetypes()->attach($serviceTypeId, ['created_by' => $userId]);
                        }
                    }
                }
                if (isset($input->maker_groups)) {
                    $tabMakerGroups = explode(',',$input->maker_groups);
                    foreach ($tabMakerGroups as $makerGroupId) {
                        if ((int)$makerGroupId) {
                            $this->makergroups()->attach($makerGroupId, ['created_by' => $userId]);
                        }
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
            $logging->info($request, 'MAKER:SAVE',[$ex->getMessage()]);
                //TODO: clear  updated object
                return $returnMsg;
            }
            DB::commit();
        }catch(\Exception $e){
            $logging = new Logging();
            $logging->info($request, 'MAKER:SAVE',[$e->getMessage()]);
            DB::rollback();
        }
        return true;
    }
}