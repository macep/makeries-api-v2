<?php

namespace App\Http\Controllers\V2;

use App\Logging;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Maker;
use App\Media;

class MediaController extends Controller
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
        $medias= $this->useFilter($request, 'Media');
        $data = $this->getSearchData($request, $medias);

        $logging = new Logging();
        $logging->info($request, 'MEDIA:LIST');
        return response()->json($data['results'])->header('X-total-count', $data['count']);
    }
    
    public function add(Request $request)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|max:255'
            ]);

        $maker = Maker::find($request->maker_id);
        if (!$maker) {
            return response('maker not found', 404);
        }

        $media = new Media;
        $media->created_by = $request->auth->userId;
        $media->maker_id = $maker->id;
        $media->name = $request->name;
        $media->url= $request->url;
        $media->save();

        return response()->json($media);
    }

    public function view(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $media = Media::find($id);
        if ($media) {
            return response()->json($media);
        }
        return response(null, 404);
    }    
    
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $media = Media::find($id);
        if (!$media) {
            return response(null, 404);
        }
        $validatedData = $this->validate($request, [
                'name' => 'required|max:255'
            ]);
        $media->name = $request->name;
        $media->url= $request->url;
        $media->updated_by = $request->auth->userId;
        $media->save();
        return response()->json($media);
    }    

    public function delete(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $media = Media::find($id);
        if (!$media) {
            return response(null, 404);
        }
        $media->delete();
        return response(null, 204);
    }    
    
}
