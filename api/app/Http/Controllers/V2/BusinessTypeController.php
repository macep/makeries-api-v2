<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\BusinessType;
use App\Http\Restrictions\BusinessTypeRestriction;

class BusinessTypeController extends Controller
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
        $businessTypes = $this->useFilter($request, 'BusinessType');
        $businessTypes = BusinessTypeRestriction::makerGroup($request, $businessTypes);
        $data = $this->getSearchData($request, $businessTypes);

        $logging = new Logging();
        $logging->info($request, 'BUSINESS_TYPE:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:business_types|max:255'
            ]);
        $businessType = new BusinessType;
        $businessType->name = $request->name;
        $businessType->created_by = $request->auth->userId;
        $businessType->save();

        return response()->json($businessType);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $businessType = BusinessTypeRestriction::findOneById($request, $id);
        if ($businessType) {
            return response()->json($businessType);
        }
        return response(null, 404);
    }    
    
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $businessType = BusinessTypeRestriction::findOneById($request, $id);
        if (!$businessType) {
            return response(null, 404);
        }
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:business_types,id,'.$id.'|max:255'
            ]);
        $businessType->name = $request->name;
        $businessType->updated_by = $request->auth->userId;
        $businessType->save();
        return response()->json($businessType);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $businessType = BusinessTypeRestriction::findOneById($request, $id);
        if (!$businessType) {
            return response(null, 404);
        }
        $businesstype->delete();
        return response(null, 204);
    }    
    
}
