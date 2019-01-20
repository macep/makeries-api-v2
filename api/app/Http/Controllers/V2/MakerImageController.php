<?php

namespace App\Http\Controllers\V2;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Image;
use App\Logging;
use App\Maker;
use App\ImageThumb;

class MakerImageController extends Controller
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

    public function index(Request $request, $makerId)
    {
        $images = Image::where('maker_id', $makerId)->get();
        $logging = new Logging();
        $logging->info($request, 'PROJECT_IMAGE:LIST');
        return response()->json($images);
    }
    
    public function add(Request $request, $makerId)
    {
        $validatedData = $this->validate($request, [
                'name' => 'required|max:255'
            ]);
        if (!is_numeric($makerId)) {
            return response(null, 400);
        }
        $maker = Maker::find($makerId);
        if (!$maker) {
            return response('Project not found', 404);
        }

        try{
            DB::beginTransaction();
            $image = new Image;
            $image->maker_id = $makerId;
            $image->created_by = $request->auth->userId;
            $image->name = $request->name;
            $image->save();
            //TODO: find better way to save in storage
            $destinationPath = __DIR__ . '/../../../../storage/images/' . ($image->id % 10);

            $request->file('upfile')->move($destinationPath, $image->id);

            $imageThumb = new ImageThumb();
            $imageThumb->create($destinationPath . '/' . $image->id);
            DB::commit();
        } catch(\Exception $ex){
            DB::rollback();
            $logging = new Logging();
            $logging->info($request, 'MAKER_IMAGE:ADD',[$ex->getMessage()]);
            return response()->json('There was a problem to save image', 500);
        }

        return response()->json($image, 201);
    }

    public function download(Request $request, $makerId, $id)
    {
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $image = Image::find($id);
        if (!$image) {
            return response(null, 404);
        }
        if ($image->maker_id != $makerId) {
            return response('invalid maker ID', 404);
        }
        $imagePath = __DIR__ . '/../../../../storage/images/' . ($image->id % 10) . '/'. $image->id;
        $downloadThumb = $request->get('thumb');
        if ((int)$downloadThumb == 1) {
            $imagePath .= '-thumb';
        }

        //TODO: check if file not exists
        if (file_exists($imagePath)) {
            return response()->download($imagePath, 'download');
            #return response()->download($imagePath, 'download', $headers, 'inline');
        }
    }

    public function delete(Request $request, $makerId, $id)
    {
        //TODO: check if the image is from the maker and had the right ROLE
        if (!is_numeric($id)) {
            return response(null, 400);
        }
        $image = Image::find($id);
        if (!$image) {
            return response(null, 404);
        }
        if ($image->maker_id != $makerId) {
            return response('invalid maker ID', 404);
        }

        $image->removeImageFile();
        $image->delete();

        return response(null, 204);
    }    
    
}
