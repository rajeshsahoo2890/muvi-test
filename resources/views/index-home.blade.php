<!DOCTYPE html>
<html lang="en">
<head>
<title>Muvi Video</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

/* Style the body */
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

/* Header/logo Title */
.header {
  padding: 80px;
  text-align: center;
  background: #1abc9c;
  color: white;
}

/* Increase the font size of the heading */
.header h1 {
  font-size: 40px;
}

/* Sticky navbar - toggles between relative and fixed, depending on the scroll position. It is positioned relative until a given offset position is met in the viewport - then it "sticks" in place (like position:fixed). The sticky value is not supported in IE or Edge 15 and earlier versions. However, for these versions the navbar will inherit default position */
.navbar {
  overflow: hidden;
  background-color: #333;
  position: sticky;
  position: -webkit-sticky;
  top: 0;
}

/* Style the navigation bar links */
.navbar a {
  float: left;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 20px;
  text-decoration: none;
}


/* Right-aligned link */
.navbar a.right {
  float: right;
}

/* Change color on hover */
.navbar a:hover {
  background-color: #ddd;
  color: black;
}

/* Active/current link */
.navbar a.active {
  background-color: #666;
  color: white;
}

/* Column container */
.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
}

/* Create two unequal columns that sits next to each other */
/* Sidebar/left column */
.side {
  -ms-flex: 30%; /* IE10 */
  flex: 30%;
  background-color: #f1f1f1;
  padding: 20px;
}

/* Main column */
.main {
  -ms-flex: 70%; /* IE10 */
  flex: 70%;
  background-color: white;
  padding: 20px;
}

/* Fake image, just for this example */
.fakeimg {
  background-color: #aaa;
  width: 100%;
  padding: 20px;
}

/* Footer */
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
}

/* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 700px) {
  .row {
    flex-direction: column;
  }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
  .navbar a {
    float: none;
    width: 100%;
  }
}
</style>
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"  crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/jquery.hoverplay.js') }}"></script>
</head>
<body>

<div class="header">
    <div class="row">
        @if(isset($videoList))
            @foreach ($videoList as $videoDet)
                @php
                    $cryptvideoId=\Crypt::encryptString($videoDet->video_id);
                @endphp
            <div class="col-md-4">
                <video width="320" height="240" controlsdata-play="hover" class="videocls" muted="muted">
                    <source src="{{asset('uploads/video/'.$videoDet->video_id.'_preview.mp4')}}" type="video/mp4">
                    {{--  <source src="{{ route('getVideo', ['id' => $cryptvideoId]) }}" type="video/mp4">  --}}
                    {{--  <source src="movie.ogg" type="video/ogg">  --}}
                </video>

                <div class="text-center">
                    <a class="btn btn-primary " href="{{ route('videoplay', ['id' => $cryptvideoId]) }}" role="button" target="_blank">Play</a>
                </div>

            </div>
            &nbsp; &nbsp;
            @endforeach

        @endif

    </div>

</div>

<script>
    $(function(){
        $('.videocls').hoverPlay({
            callbacks: {
                play: function(el, video) {
                video.play();
                el.addClass('hoverPlay');
                },
                pause: function(el, video) {
                video.pause();
                el.removeClass('hoverPlay');
                },
                click: function(el, video, e) {
                e.preventDefault();
                }
            }
        });
    });
</script>


</body>
</html>

