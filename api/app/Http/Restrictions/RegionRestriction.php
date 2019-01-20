<?php
namespace App\Http\Restrictions;

class RegionRestriction
{
    
    public static function makerGroup($request, $object)
    {
        if (isset($request->auth->accessToGroup)) {
            $object = $object->join('maker_group_region', 'regions.id', '=', 'maker_group_region.region_id')
                        ->whereIn('maker_group_region.maker_group_id', $request->auth->accessToGroup);
        }
        return $object;
    }

    public static function findOneById($request, $id)
    {
        if (isset($request->auth->accessToGroup)) {
            return \App\Region::select('regions.*')
                        ->join('maker_group_region', 'regions.id', '=', 'maker_group_region.region_id')
                        ->whereIn('maker_group_region.maker_group_id', $request->auth->accessToGroup)
                        ->find($id);
        }
        return \App\Region::find($id);
    }

}