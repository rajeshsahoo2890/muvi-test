<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Carbon\Carbon;

class VideoController extends Controller
{
    public function index($id = null)
    {
        $data = [];
            return view('pages.video.index', $data);
    }

    public function add($id = null)
    {
        $data = [];
        if($id){
            $video_id = Crypt::decryptString($id);
            $data['video'] = Video::find($video_id);
            return view('pages.video.edit', $data);
        }else{
            return view('pages.video.edit', $data);
        }
    }

    public function post(Request $request)
    {
        if(isset($request->video_id)){
            $video = Video::find($request->video_id);
            $request->validate([
                'title' => 'required',
                'video_file' => 'mimes:mp4',
                'video_image' => 'mimes:jpeg,jpg,png,gif',
                'publish_date' => 'required',
            ]);
        }else{
            $video = new video();
            $request->validate([
                'title' => 'required',
                'video_file' => 'required | mimes:mp4',
                'video_image' => 'required | mimes:jpeg,jpg,png,gif',
                'publish_date' => 'required',
            ]);

        }
        $video->title = $request->title;

        $video->publish_date = Carbon::createFromFormat('d/m/Y', $request->publish_date)->format('Y-m-d');
        $video->video_image = $request->video_image->store('image', 'local');
        $video->video_file = $request->video_file->store('videos', 'videos_disk');
        $video->save();
        $this->dispatch(new ConvertVideoForStreaming($video));

        return redirect()->route('admin.video')->with("message", 'Video Added/Updated Successfully');
    }

    public function datatable(Request $request)
    {
        $input = $request->all();

        $DataQuery = $countQuery = DB::table('videos');

        $count  = $countQuery->count('video_id');
        if($input['length'] != -1) {
            $DataQuery   =  $DataQuery->skip($input['start'])->take($input['length']);
            $DataQuery   =  $DataQuery->orderBy('title', 'asc');
        }

        $arrRes   = $DataQuery->get();

        foreach ($arrRes as $k => $v) {
            $videoImg=asset('uploads/'.$v->video_image);
            $arrRes[$k]->slNo = ++$input['start'];
            $arrRes[$k]->Id = Crypt::encryptString($v->video_id);
            $arrRes[$k]->publish_date = date('d-m-Y', strtotime($v->publish_date));
            $arrRes[$k]->poster_image = '<img src="'.$videoImg.'" alt="" height="80">';
        }

        return response()
		->json(
			[
				//'input' => $input, // for debuging request data
				//'condition' => $arrConditions, // for debuging condition to database
				'recordsTotal' => $count,
				'recordsFiltered' => $count,
                'data' => $arrRes,

			]
		);
    }

    public function status($id)
    {
        $video_id = Crypt::decryptString($id);
        $video = Video::find($video_id);
        $video->is_active = !$video->is_active;
        $video->save();
        return response()
            ->json(
                [
                    'msg' => 'Video Status Updated',
                ]
            );
    }

}
