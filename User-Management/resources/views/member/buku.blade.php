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
    .dpl {
        padding: 0px;
        height: 30px;
    }
    .tn {
        font-size: 12px;
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
        <h6 class="m-0 font-weight-bold text-primary">Tabel Daftar Buku</h6>
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
            <a class="dropdown-item" href="/buku/add">Tambahkan Buku Baru</a>
            <a class="dropdown-item" data-toggle="modal" data-target="#modalForm">Import Data Buku</a>
            <a class="dropdown-item" onclick="exportexcel()">Export Data Buku</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" onclick="multipledelete()">Hapus Beberapa Buku Sekaligus</a>
            </div>
        </div>
        @endrole
    </div>
    <div class="card-body overflow-auto">
        <form id="ghost" method="POST" action="/data/buku/deletes" enctype="multipart/form-data">
        @csrf
            <table class="table table-bordered d-wrap" id="bukutable" width="100%" cellspacing="0">
                <thead>
                    <tr role="row">
                        <th id="no">No</th>
                        <th id="1"><div class="dropdown clscol">
                        </div>Posted</th>
                        <th id="2"><div class="dropdown clscol">
                        </div>Cover</th>
                        <th id="3"><div class="dropdown clscol">
                        </div>Pdf</th>
                        <th id="4"><div class="dropdown clscol">
                        </div>Judul</th>
                        <th id="5"><div class="dropdown clscol">
                        </div>Stock</th>
                        <th id="6"><div class="dropdown clscol">
                        </div>Pengarang</th>
                        <th id="7"><div class="dropdown clscol">
                        </div>Penerbit</th>
                        <th id="8"><div class="dropdown clscol">
                        </div>Tgl Terbit</th>
                        <th id="9"><div class="dropdown clscol">
                        </div>Tebal Buku</th>
                        <th id="10"><div class="dropdown clscol">
                        </div>Harga Sekarang</th>
                        <th id="11"><div class="dropdown clscol">
                        </div>Harga Sebelumnya</th>
                        <th id="12"><div class="dropdown clscol">
                        </div>Created at</th>
                        <th id="13"><div class="dropdown clscol">
                        </div>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ib as $data)
                    <tr id="scrow{{$data->id}}" class="trw">
                        <td class="cn"></td>
                        <td class="ci1">{{$data->userpost_id}}</td>
                        <td class="ci2">{{$data->cover}}</td>
                        <td class="ci3">{{$data->pdf}}</td>
                        <td class="ci4">{{$data->judul}}</td>
                        <td class="ci5">{{$data->jumlah}}</td>
                        <td class="ci6">{{$data->pengarang}}</td>
                        <td class="ci7">{{$data->penerbit}}</td>
                        <td class="ci8">{{$data->terbit}}</td>
                        <td class="ci9">{{$data->tebal_buku}}</td>
                        <td class="ci10">{{$data->harga}}</td>
                        <td class="ci11">{{$data->harga_sebelumnya}}</td>
                        <td class="ci12">{{$data->created_at->format('Y-m-d')}}</td>
                        <td class="ci13">{{$data->updated_at}}</td>
                        <td>
                        <div class="btn-group optional" id="atc{{$data->id}}">
                            <a href="/buku/direct/{{$data->id}}">
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
                                    <h5 class="modal-title" id="exampleModalLabel">Kamu yakin ingin menghapusnya?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Data yang dihapus adalah {{$data->name}}.</div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="button" data-dismiss="modal">Batalkan</button>
                                    <a class="btn btn-danger" href="/data/buku/delete/{{$data->id}}">Hapus Data</a>
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
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-inline">
                <p class="text my-auto tbshow"></p>
            </div>
            <div class="d-flex flex-inline">
                <p class="text my-auto mr-3">Halaman</p>
                <div class="btn-group" id="tbpage" role="group" aria-label="Basic example">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="modalForm" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload file</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data" action="/import">
                @csrf
                <div class="modal-body">
                    <input type="file" accept=".xls,.xlsx" name="excel" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success mr-auto" value="Import">Upload</button>
                    </form>
                <button class="btn btn-primary" type="button" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
@push('enscript')
<script>
let coltype = [];
let colname = [];
<?php foreach($cf as $ac) {?>
coltype.push('<?php echo $ac ?>');
<?php }?>
<?php foreach($ch as $ac) {?>
colname.push('<?php echo $ac ?>');
<?php }?>

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
        if($(':checkbox:checked').length === 0) {
            alert("pilih minimal satu file");
        }else{
            $('#ghost').submit();
        }
        return false;
    }
}
function exportexcel() {
    let idss = [];
    idss[0] = 5;
    idss[1] = 10;
    $('#ghost').prop('action', '/export');
    $('#ghost').prop('method', 'get');
    $('#ghost').submit();
}

</script>
<script src="{{asset('filter')}}/tablefilter.js"></script>
@endpush
@stack('modal')
@endsection