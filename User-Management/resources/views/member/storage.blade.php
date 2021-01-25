@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<?php $is_image = ['jpg', 'jpeg', 'png'];?>
<div class="modal fade bd-example-modal-xl" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> 
        <img src="" class="w-100" id="imagepreview">
        <button type="button" class="btn btn-default float-left" data-dismiss="modal"></button>
    </div>
</div>
@isset($all)
@push('enscript')
<script>
    let mode1 = new Array();
    let mode2 = new Array();
</script>
@endpush
@foreach($all as $data)
<?php
$type = 'fa-file';
$ext = pathinfo($data->path)['extension'];
if (in_array($ext, $is_image)) {
    $type = 'fa-image';
}
$path = Storage::url('public/'.$data->path);
?>
@push('files')
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        {{$data->name}}
                    </div>
                </div>
                <div class="col-auto">
                    <div class="row optional" id="atc<?=$data->id?>">
                        <i class="fas {{$type}} fa-2x text-gray-300 mr-2"></i>
                        <div class="dropdown no-arrow my-auto">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{$path}}" download>Download</a>
                                <button type="button" class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-xl" id="pop{{$data->id}}">Preview</button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/deletefile/{{$data->id}}">Delete</a>
                            </div>
                        </div>
                    </div>
                    <input type="checkbox" id="atc<?=$data->id?>" name="id[]" value="<?=$data->id?>" class="d-none btn form-control cchecks cb-lg">
                </div>
            </div>
        </div>
    </div>
</div>
@endpush
@push('enscript')
<script>
$("#pop<?=$data->id?>").on("click", function() {
   $('#imagepreview').attr('src', "<?=$path?>"); 
   $('#imagemodal').modal('show');
});
</script>
@endpush
@endforeach
@push('enscript')
<script>
function multipledelete() {
        $('#mbdelete').attr('onclick', 'resure()');

        $('.optional').each(function(){
            $(this).toggleClass('d-none');
        });

        $('.cchecks').each(function(){
            $(this).prop('checked', false);
            $(this).toggleClass('d-none');
        });
        $('#cancel').toggleClass('d-none');
        $('#icon').toggleClass('fa-trash fa-check');
    }
    function disablemulti() {
        $('#mbdelete').attr('onclick', 'multipledelete()');
        $('.optional').each(function(){
            $(this).toggleClass('d-none');
        });
        $('.cchecks').each(function(){
            $(this).prop('checked', false);
            $(this).toggleClass('d-none');
        });
        $('#cancel').toggleClass('d-none');
        $('#icon').toggleClass('fa-trash fa-check');
    }
    function resure() {
        if(confirm("Apakan Anda yakin ingin menghapus file-file ini?")){
            let id = [];
            $(':checkbox:checked').each(function(i){
                id[i] = $(this).val();
            });

            if(id.length === 0) {
                alert("pilih minimal satu file");
            }else{
                $('#ghost').submit();
            }
            return false;
        }
    }
</script>
@endpush
@endisset
@push('bgstyle')
<style>
    body, html, #wrapper{
        height: 100%;
    }
    h1 {
        font-size: 1000%;
    }
    .cb-lg {
        width: 32px;
        height: 32px;
    }
</style>
@endpush
<form class="container-fluid pt-4 mb-auto" action="/deletefiles" method="POST" enctype="multipart/form-data" id="ghost">
    @csrf
    <div class="d-flex aligment-items-center mb-4">
        <div class="d-sm-flex justify-content-between my-auto">
            <h1 class="h3 mb-0 text-gray-800">Storage</h1>
        </div>
        <div class="ml-auto">
            <a class="d-none btn btn-primary btn-circle mr-4 shadow" id="cancel" onclick="disablemulti()">
                <i class="fas fa-times"></i>
            </a>
            <a class="btn btn-danger btn-icon-split shadow" id="mbdelete" onclick="multipledelete()">
                <span class="icon text-white-50">
                    <i id="icon" class="fas fa-trash"></i>
                </span>
                <span id="labeld" class="text">Delete Data</span>
            </a>
        </div>
    </div>
    <div class="row" id="morph">
        <div class="col-xl-3 col-md-6 mb-4">
            <a class="card btn border-left-success shadow h-100 w-100 py-2" data-toggle="modal" data-target="#modalForm">
                <div class="card-body w-100">
                    <div class="row no-gutters align-items-center justify-content-between">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Add file</div>
                        <i class="fas fa-plus fa-2x text-success ml-auto p-0"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tasks Card Example -->
        @stack('files')

    </div>
</form>

<div class="modal fade" id="modalForm" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload file</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data" action="/upload">
                @csrf
                <div class="modal-body">
                    <input type="file" accept=".pdf,.xls,.xlsx,.doc,.docx,.ppt,.jpg,.jpeg,.png" name="file" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success mr-auto">Upload</button>
                    </form>
                <button class="btn btn-primary" type="button" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
@endsection