@extends('layout.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
     <!-- start page title -->
     <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Video</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.video') }}">Video List</a></li>
                        <li class="breadcrumb-item active">Video ADD/Edit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header bg-primary text-white-50">
                    <h5>Add Video</h5>
                </div>
                <div class="card-body">
                    @include('partial.msg')
                    <form method="POST" action="{{ route('admin.video.post') }}" enctype="multipart/form-data">
                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Video Title</label>
                                    <input type="text" class="form-control"
                                    name="title" id="title"
                                    value="{{ isset($video) ? $video->title : ''}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Video</label>
                                    <input type="file" class="form-control"
                                    name="video_file" id="video_file">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Video Poster Image</label>
                                    <input type="file" class="form-control"
                                    name="video_image" id="video_image">

                                    @if(isset($video))
                                    <img src="{{ asset('uploads/'.$video->video_image) }}" alt="" height="60">
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Publish Date</label>
                                    <input type="text" class="form-control"
                                    name="publish_date" id="publish_date"
                                    value="{{ isset($video) ? date('d-m-Y', strtotime($video->publish_date)) : ''}}">
                                </div>
                            </div>



                        </div>

                        @csrf
                        @isset($video)
                            <input type="hidden" name="video_id" value="{{ $video->video_id }}">
                        @endisset
                        <button type="submit" class="btn btn-primary waves-effect waves-light "
                                style="float: right;">Save changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection


@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<script>
    $(document).ready(function(){

        $('#publish_date').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'en'
        });

    });
</script>
@endpush
