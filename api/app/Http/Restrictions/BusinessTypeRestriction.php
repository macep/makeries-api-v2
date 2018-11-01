<?php
namespace App\Http\Restrictions;

class BusinessTypeRestriction
{
    
    public static function makerGroup($request, $object)
    {
        if (isset($request->auth->accessToGroup)) {
            $object = $object->join('maker_group_business_type', 'business_types.id', '=', 'maker_group_business_type.business_type_id')
                        ->whereIn('maker_group_business_type.maker_group_id', $request->auth->accessToGroup);
        }
        return $object;
    }

    public static function findOneById($request, $id)
    {
        if (isset($request->auth->accessToGroup)) {
            return \App\BusinessType::select('business_types.*')
                        ->join('maker_group_business_type', 'business_types.id', '=', 'maker_group_business_type.business_type_id')
                        ->whereIn('maker_group_business_type.maker_group_id', $request->auth->accessToGroup)
                        ->find($id);
        }
        return \App\BusinessType::find($id);
    }

}