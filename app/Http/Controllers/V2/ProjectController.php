<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Project;
use App\Maker;

class ProjectController extends Controller
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
        $projects= $this->useFilter($request, 'Project');
        $data = $this->getSearchData($request, $projects);

        $logging = new Logging();
        $logging->info($request, 'PROJECT:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:projects|max:255',
                'maker_id' => 'required',
            ]);
        if (filter_var($request->maker_id, FILTER_VALIDATE_INT) === false) {
            return response('invalid maker id', 400);
        }
        //TODO: find a way to filter with accessRole limitation
        $maker = Maker::find($request->maker_id);
        if (!$maker) {
            return response('maker not found', 400);
        }
        $project = new Project;
        $project->created_by = $request->auth->userId;
        $project->maker_id = $request->maker_id;
        if ($request->has('description')) {
            $project->description = $request->description;
        }
        $project->save();

        return response()->json($project);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $project = Project::find($id);
        if ($project) {
            return response()->json($project);
        }
        return response(null, 404);
    }    
    
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        //TODO:: get project with limitation
        $project = Project::find($id);
        if (!$project) {
            return response(null, 404);
        }
        $validatedData = $this->validate($request, [
                'name' => 'required|unique:projects,id,'.$id.'|max:255',
                'maker_id' => 'required'
            ]);
        //TODO: find a way to filter with accessRole limitation
        $maker = Maker::find($request->maker_id);
        if (!$maker) {
            return response('maker not found', 400);
        }
        $project->name = $request->name;
        if ($request->has('description')) {
            $project->description = $request->description;
        }
        $project->updated_by = $request->auth->userId;
        $project->save();
        return response()->json($project);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $project = Project::find($id);
        if (!$project) {
            return response(null, 404);
        }
        $project->delete();
        return response(null, 204);
    }    
    
}
