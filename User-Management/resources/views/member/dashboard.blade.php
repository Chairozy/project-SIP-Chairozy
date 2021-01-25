@extends('layouts.app')
@push('enscript')
<script>
let img = new Image();
img.src = $('#jimg').attr("src");
img.onload = function() {
    let val = Math.min(this.width, this.height);
    scale = val / 300;
    nw = this.width / scale;
    nh = this.height / scale;
    $('#jimg').attr('width', nw);
    $('#jimg').attr('height', nh);
    $('.cropped').toggleClass('d-none');
}
</script>
@endpush
@push('bgstyle')
<style>
    body, html, #wrapper{
        height: 100%;
    }
    h1 {
        font-size: 500%;
    }
    .cropped {
        width: 300px;
        height: 300px;
        overflow: hidden;
        border-radius: 50%;
    }

    .cropped img {
        margin: 0px 0px 0px 0px;
    }
</style>
@endpush
@section('content')
<main class="mt-auto" role="main">
    <div class="d-flex row">
    <div class="col-12">
    <h2 class="text-center">Welcome back</h2>
    </div>
    <div class="col-12">    
    <div class="cropped mx-auto d-none"><img src="{{Storage::url('public/'.$ct->photo)}}" alt="preview" id="jimg"></div>
    </div>
    <div class="col-12"> 
        <h1 class="text-center">{{$ct->name}}</h1>
    </div>
    </div>
</main>
@endsection
