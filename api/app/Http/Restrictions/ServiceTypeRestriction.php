<?php
namespace App\Http\Restrictions;

class ServiceTypeRestriction
{
    
    public static function makerGroup($request, $object)
    {
        if (isset($request->auth->accessToGroup)) {
            $object = $object->join('maker_group_service_type', 'service_types.id', '=', 'maker_group_service_type.service_type_id')
                        ->whereIn('maker_group_service_type.maker_group_id', $request->auth->accessToGroup);
        }
        return $object;
    }

    public static function findOneById($request, $id)
    {
        if (isset($request->auth->accessToGroup)) {
            return \App\ServiceType::select('service_types.*')
                        ->join('maker_group_service_type', 'service_types.id', '=', 'maker_group_service_type.service_type_id')
                        ->whereIn('maker_group_service_type.maker_group_id', $request->auth->accessToGroup)
                        ->find($id);
        }
        return \App\ServiceType::find($id);
    }

}