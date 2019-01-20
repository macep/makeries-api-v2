<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\ServiceType;
use App\Http\Restrictions\ServiceTypeRestriction;

class ServiceTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
    }

    public function index(Request $request)
    {
        $serviceTypes = $this->useFilter($request, 'ServiceType');
        $serviceTypes = ServiceTypeRestriction::makerGroup($request, $serviceTypes);
        $data = $this->getSearchData($request, $serviceTypes);

        $logging = new Logging();
        $logging->info($request, 'SERVICE_TYPE:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:service_types|max:255'
            ]);
        $serviceType = new ServiceType;
        $serviceType->name = $request->name;
        $serviceType->created_by = $request->auth->userId;
        $serviceType->save();

        return response()->json($serviceType, 201);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $serviceType = ServiceTypeRestriction::findOneById($request, $id);
        if ($serviceType) {
            return response()->json($serviceType);
        }
        return response(null, 404);
    }    
    
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $serviceType = ServiceTypeRestriction::findOneById($request, $id);
        if (!$serviceType) {
            return response(null, 404);
        }
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:service_types,name,'.$id.'|max:255'
            ]);
        $serviceType->name = $request->name;
        $serviceType->updated_by = $request->auth->userId;
        $serviceType->save();
        return response()->json($serviceType);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $serviceType = ServiceTypeRestriction::findOneById($request, $id);
        if (!$serviceType) {
            return response(null, 404);
        }
        $serviceType->delete();
        return response(null, 204);
    }    
    
}
