<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Region;
use App\Http\Restrictions\RegionRestriction;

class RegionController extends Controller
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
        $regions= $this->useFilter($request, 'Region');
        $regions = RegionRestriction::makerGroup($request, $regions);
        $data = $this->getSearchData($request, $regions);

        $logging = new Logging();
        $logging->info($request, 'REGION:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:regions|max:255'
            ]);
        $region = new Region;
        $region->created_by = $request->auth->userId;
        $region->name = $request->name;
        $region->save();

        return response()->json($region);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $region = RegionRestriction::findOneById($request, $id);
        if ($region) {
            return response()->json($region);
        }
        return response(null, 404);
    }    
    
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $region = RegionRestriction::findOneById($request, $id);
        if (!$region) {
            return response(null, 404);
        }
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:regions,id,'.$id.'|max:255'
            ]);
        $region->name = $request->name;
        $region->updated_by = $request->auth->userId;
        $region->save();
        return response()->json($region);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $region = RegionRestriction::findOneById($request, $id);
        if (!$region) {
            return response(null, 404);
        }
        $region->delete();
        return response(null, 204);
    }    
    
}
