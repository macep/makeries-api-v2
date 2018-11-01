<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Restrictions\ProductRestriction;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $products = $this->useFilter($request, 'Product');
        $products = ProductRestriction::makerGroup($request, $products);
        $data = $this->getSearchData($request, $products);

        $logging = new Logging();
        $logging->info($request, 'PRODUCT:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:products|max:255'
            ]);
        $product = new Product;
        $product->created_by = $request->auth->userId;
        $product->name = $request->name;
        $product->save();

        return response()->json($product);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $product = ProductRestriction::findOneById($request, $id);
        if ($product) {
            return response()->json($product);
        }
        return response(null, 404);
    }    
    
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $product = ProductRestriction::findOneById($request, $id);
        if (!$product) {
            return response(null, 404);
        }
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:products,id,'.$id.'|max:255'
            ]);
        $product->name = $request->name;
        $product->updated_by = $request->auth->userId;
        $product->save();
        return response()->json($product);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $product = ProductRestriction::findOneById($request, $id);
        if (!$product) {
            return response(null, 404);
        }
        $product->delete();
        return response(null, 204);
    }    
    
}
