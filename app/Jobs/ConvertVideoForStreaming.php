<?php

namespace App\Jobs;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $media = FFMpeg::fromDisk('videos_disk')
        ->open($this->video->video_file);

        $durationInSeconds = $media->getDurationInSeconds();

        $clipFilter = new \FFMpeg\Filters\Video\ClipFilter(
            \FFMpeg\Coordinate\TimeCode::fromSeconds(0),
            \FFMpeg\Coordinate\TimeCode::fromSeconds(ceil( $durationInSeconds * 0.02 )),
        );
        $media->export()
        ->toDisk('local')
        ->inFormat(new \FFMpeg\Format\Video\X264)
        ->save('video/'.$this->video->video_id . '.mp4');

        $media->addFilter($clipFilter)
        ->export()
        ->toDisk('local')
        ->inFormat(new \FFMpeg\Format\Video\X264)
        ->save('video/'.$this->video->video_id . '_preview' . '.mp4');

    // update the database so we know the convertion is done!
    $this->video->update([
        'converted_for_streaming_at' => Carbon::now(),
    ]);
    }
}
