@extends('layouts.app')
@push('bgstyle')
<style>
    .masthead {
        width: 100%;
        min-height: 400px;
        background-image: url('bgkelas.jpg');
        background-position: center;
        background-repeat: no-repeat;
    }
</style>
@endpush
@section('content')
<header class="masthead">
    <div class="row masthead h-100 align-items-center">
        <div class="col-3"></div>
        <div class="col-6 text-center" style="background-color:rgba(255,255,255,0.9);"><br>
            <h1 class="text-secondary">Buku</h1>
            <p class="text-secondary">Ada beragam buku yang bisa kamu dapatkan disini</p>
        </div>
    </div>
</header>
<div class="container">
    <br><br><br>
    <div class="row justify-content-center py-5">
        <div class="col-sm-9 mx-auto"><p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p><br><br>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card bg-primary text-white text-center p-3">
                <blockquote class="blockquote mb-0">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat.</p>
                    <footer class="blockquote-footer text-white">
                        <small>
                        Someone famous in <cite title="Source Title">Source Title</cite>
                        </small>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-primary text-white text-center p-3">
                <blockquote class="blockquote mb-0">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat.</p>
                    <footer class="blockquote-footer text-white">
                        <small>
                        Someone famous in <cite title="Source Title">Source Title</cite>
                        </small>
                    </footer>
                </blockquote>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center py-5">
        <div class="col-sm-9 mx-auto"><p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p><br><p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p><br><p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p></div>
    </div>
</div>

@endsection
