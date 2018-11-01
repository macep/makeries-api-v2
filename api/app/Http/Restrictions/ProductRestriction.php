<?php
namespace App\Http\Restrictions;

class ProductRestriction
{
    
    public static function makerGroup($request, $object)
    {
        if (isset($request->auth->accessToGroup)) {
            $object = $object->join('maker_group_product', 'products.id', '=', 'maker_group_product.product_id')
                        ->whereIn('maker_group_product.maker_group_id', $request->auth->accessToGroup);
        }
        return $object;
    }

    public static function findOneById($request, $id)
    {
        if (isset($request->auth->accessToGroup)) {
            return \App\Product::select('products.*')
                        ->join('maker_group_product', 'products.id', '=', 'maker_group_product.product_id')
                        ->whereIn('maker_group_product.maker_group_id', $request->auth->accessToGroup)
                        ->find($id);
        }
        return \App\Product::find($id);
    }

}