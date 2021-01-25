@extends('layouts.app')

@section('title', 'Users')

@section('content')
@push('bgstyle')
<style>
    body, html, #wrapper{
        height: 100%;
    }
    h1 {
        font-size: 1000%;
    }
    .cb-lg {
        width: 25px;
        height: 25px;
    }
    .rowc {
        background-color: crimson;
        color: white;
    }
</style>
@endpush
@if (session('pesan'))
<div class="modal fade" id="modAlert" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{session('pesan')}}.</div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@push('modalscript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#modAlert').modal('show');
    })
</script>
@endpush
@endif
<div class="px-4 py-4 mb-auto">
<div class="card shadow mb-4">
    <div class="card-header navbar py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Pengguna</h6>
        @role('Admin')
        <div class="ml-auto">
            <a class="d-none btn btn-primary btn-circle mr-4 shadow" id="cancel" onclick="disablemulti()">
                <i class="fas fa-times"></i>
            </a>
            <a class="btn btn-danger btn-icon-split shadow d-none" id="mbdelete" onclick="resure()">
                <span class="icon text-white-50">
                    <i id="icon" class="fas fa-trash"></i>
                </span>
                <span id="labeld" class="text">Delete Data</span>
            </a>
        </div>
        <div class="btn-group" id="mchoose">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edits</button>
            <div class="dropdown-menu shadow" x-placement="bottom-start" style="position: absolute; transform: translate3d(-170px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a class="dropdown-item" href="/user/add">Tambahkan User Baru</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" onclick="multipledelete()">Hapus Beberapa User Sekaligus</a>
            </div>
        </div>
        @endrole
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form id="ghost" method="POST" action="deletes" enctype="multipart/form-data">
            @csrf
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="align-middle col">Username</th>
                            <th class="align-middle col">Name</th>
                            <th class="align-middle col">Email</th>
                            <th class="align-middle col">Phone</th>
                            <th class="align-middle col">Gender</th>
                            <th class="align-middle col">Kebangsaan</th>
                            <th class="align-middle col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all as $data)
                        <tr role="row" class="srow" id="scrow{{$data->id}}">
                            <td>{{$data->username}}<br><div class="bg-primary pr-3 rounded-lg"><p class="text-white text-right"><small>Role:</small> {{$data->role_id}}</p></div></td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->gender}}</td>
                            <td>{{$data->kebangsaan}}</td>
                            <td>
                            <div class="btn-group optional" id="atc{{$data->id}}">
                                <a href="/direct/{{$data->id}}">
                                <button type="button" class="btn btn-success">
                                    <i class="fas fa-info-circle"></i>
                                </button></a>
                                @role('Admin')
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dm{{$data->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endrole
                            </div>
                            <input type="checkbox" id="{{$data->id}}" name="id[]" value="<?=$data->id?>" class="d-none btn form-control cchecks cb-lg" onclick="checks(this)">
                            </td>
                        </tr>
                        @role('Admin')
                        @push('modal')
                        <div class="modal fade" id="dm{{$data->id}}" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Kau yakin ingin menghapusnya?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Data yang dihapus adalah {{$data->name}}.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="button" data-dismiss="modal">Batalkan</button>
                                        <a class="btn btn-danger" href="/delete/{{$data->id}}">Hapus Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endpush
                        @endrole
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
</div>
@push('enscript')
<script>
function checks(self) {
    n = $(self).attr('id');
    $('#scrow'+n).toggleClass('rowc');
}
function multipledelete() {
    $('#mbdelete').toggleClass('d-none');
    $('#mchoose').toggleClass('d-none');

    $('.srow').each(function(){
        $(this).toggleClass('crow');
    });

    $('.optional').each(function(){
        $(this).toggleClass('d-none');
    });

    $('.cchecks').each(function(){
        $(this).prop('checked', false);
        $(this).toggleClass('d-none');
    });
    $('#cancel').toggleClass('d-none');
}
function disablemulti() {
    $('#mbdelete').toggleClass('d-none');
    $('#mchoose').toggleClass('d-none');
    $('.optional').each(function(){
        $(this).toggleClass('d-none');
    });
    $('.cchecks').each(function(){
        if($(this).is(':checked')){
            $(this).toggleClass('rowc');
            $(this).prop('checked', false);
            checks($(this));
        }
        $(this).toggleClass('d-none');
    });
    $('.srow').each(function(){
        $(this).toggleClass('crow');
    });
    $('#cancel').toggleClass('d-none');
}
function resure() {
    if(confirm("Apakan Anda yakin ingin menghapus data-data ini?")){
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
@stack('modal')
@endsection