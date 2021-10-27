<?php
/**
 * Desription
 *
 */
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Video;
use Storage;
use Illuminate\Support\Facades\Response;

use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        $videoList=DB::table('videos')
        ->select('video_id','title','video_file','video_image')
        ->where('publish_date','>','')
        ->where('is_active',1)
        ->get();

        $this->viewVars['videoList'] = $videoList;
        return view('index-home',$this->viewVars);
    }

    public function videoPlay($id)
    {
        $video_id = Crypt::decryptString($id);
        $video = Video::find($video_id);
        $this->viewVars['video'] = $video;
        return view('index-home-video',$this->viewVars);
    }

    public function getVideo($id)
    {
        $video_id = Crypt::decryptString($id);
        $video = Video::find($video_id);
        $name = $video->video_file;
        $fileContents = Storage::disk('videos_disk')->get($name);
        $response = Response::make($fileContents, 200);
        $response->header('Content-Type', "video/mp4");
        return $response;
    }

}
