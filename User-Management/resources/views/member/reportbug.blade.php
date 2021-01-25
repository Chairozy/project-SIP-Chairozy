@extends('layouts.app')
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
    <h2 class="text-center">Laporkan masalah page</h2>
    </div>
    </div>
</main>
@endsection
