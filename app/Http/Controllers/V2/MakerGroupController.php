<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\MakerGroup;

class MakerGroupController extends Controller
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
        $makerGroups = $this->useFilter($request, 'MakerGroup');
        if (isset($request->auth->accessToGroup)) {
            $makerGroups = $makerGroups->whereIn('id', $request->auth->accessToGroup);
        }
        $makerGroups = $makerGroups->with('businesstypes')
                                    ->with('products')
                                    ->with('regions')
                                    ->with('servicetypes');

        $data = $this->getSearchData($request, $makerGroups);

        $logging = new Logging();
        $logging->info($request, 'MAKER_GROUP:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:maker_groups|max:255'
            ]);
        $makerGroup = new MakerGroup;
        if ($makerGroup->insertObject($request)) {
            return response()->json($makerGroup);
        }

        return response('Error while save data', 400);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $makerGroup = MakerGroup::where('id','>=',1);
        if (isset($request->auth->accessToGroup)) {
            $makerGroup = $makerGroup->whereIn('id', $request->auth->accessToGroup);
        }
        $makerGroup = $makerGroup->with('businesstypes')
                            ->with('products')
                            ->with('regions')
                            ->with('servicetypes')
                            ->find($id);

        if ($makerGroup) {
            return response()->json($makerGroup);
        }
        return response(null, 404);
    }    

    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $makerGroup = MakerGroup::where('id','>=',1);
        if (isset($request->auth->accessToGroup)) {
            $makerGroup = $makerGroup->whereIn('id', $request->auth->accessToGroup);
        }
        $makerGroup = $makerGroup->find($id);
        if (!$makerGroup) {
            return response(null, 404);
        }
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:maker_groups,id,'.$id.'|max:255'
            ]);
        $makerGroup->updateObject($request);

        $makerGroup = MakerGroup::with('businesstypes')
                            ->with('products')
                            ->with('regions')
                            ->with('servicetypes')
                            ->find($id);

        return response()->json($makerGroup);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $makerGroup = MakerGroup::where('id','>=',1);
        if (isset($request->auth->accessToGroup)) {
            $makerGroup = $makerGroup->whereIn('id', $request->auth->accessToGroup);
        }
        $makerGroup = $makerGroup->find($id);
        if (!$makerGroup) {
            return response(null, 404);
        }
        $makerGroup->delete();
        return response(null, 204);
    }    
    
}
