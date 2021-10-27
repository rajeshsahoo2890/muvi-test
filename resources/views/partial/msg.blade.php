@if(Session::has('message'))
    <div class="alert alert-success">
        <i class="fa fa-check"></i> {!! Session::get('message') !!}
    </div>
@endif
@if(Session::has('errmessage'))
    <div class="alert alert-danger">
        <i class="fa fa-times-circle-o"></i> {{ Session::get('errmessage') }}
    </div>
@endif
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <i class="fa fa-times-circle-o"></i> {{ $error }}
        </div>
    @endforeach
@endif