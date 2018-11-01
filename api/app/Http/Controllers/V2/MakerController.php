<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Maker;

class MakerController extends Controller
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
        $makers = $this->useFilter($request, 'Maker');
        if (isset($request->auth->accessToGroup)) {
            $makers = $makers->whereHas('makergroups', function($q) use($request) {
                            $q->whereIn('maker_group_id', $request->auth->accessToGroup);
                        });
        }
        $makers = $makers->with('businesstypes')
                            ->with('images')
                            ->with('medias')
                            ->with('products')
                            ->with('projects')
                            ->with('regions')
                            ->with('servicetypes')
                            ->with('makergroups');
                            #->get();
        $data = $this->getSearchData($request, $makers);

        $logging = new Logging();
        $logging->info($request, 'MAKER:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $maker = new Maker;
        $resp = $maker->insertObject($request);

        if (!is_bool($resp)) {
            return response()->json($resp, 401);
        }
        $maker = Maker::with('businesstypes')
                            ->with('images')
                            ->with('medias')
                            ->with('products')
                            ->with('projects')
                            ->with('regions')
                            ->with('servicetypes')
                            ->with('makergroups')
                            ->find($maker->id);

        return response()->json($maker,201);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $maker = Maker::with('businesstypes')
                            ->with('images')
                            ->with('medias')
                            ->with('products')
                            ->with('projects')
                            ->with('regions')
                            ->with('servicetypes')
                            ->with('makergroups')
                            ->find($id);
        if ($maker) {
            return response()->json($maker);
        }
        return response(null, 404);
    }    
    
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $maker = Maker::find($id);
        if (!$maker) {
            return response(null, 404);
        }
        $maker->updateObject($request);

        $maker = Maker::with('businesstypes')
                            ->with('images')
                            ->with('medias')
                            ->with('products')
                            ->with('projects')
                            ->with('regions')
                            ->with('servicetypes')
                            ->with('makergroups')
                            ->find($id);

        return response()->json($maker);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $maker = Maker::find($id);
        if (!$maker) {
            return response(null, 404);
        }
        $maker->delete();
        return response(null, 204);
    }    
    
}
