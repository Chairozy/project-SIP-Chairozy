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
        <form id="ghost" method="POST" action="deletes" enctype="multipart/form-data">
        @csrf
            <table class="table table-bordered d-wrap" id="bukutable" width="100%" cellspacing="0">
                <thead>
                    <tr role="row">
                        <th id="1"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s1" name="s1" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i1" name="i1" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Posted</th>
                        <th id="2"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s2" name="s2" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i2" name="i2" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Cover</th>
                        <th id="3"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s3" name="s3" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i3" name="i3" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Pdf</th>
                        <th id="4"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s4" name="s4" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i4" name="i4" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Judul</th>
                        <th id="5"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s5" name="s5" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i5" name="i5" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Stock</th>
                        <th id="6"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s6" name="s6" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i6" name="i6" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Pengarang</th>
                        <th id="7"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s7" name="s7" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i7" name="i7" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Penerbit</th>
                        <th id="8"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s8" name="s8" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i8" name="i8" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Tgl Terbit</th>
                        <th id="9"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s9" name="s9" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i9" name="i9" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Tebal Buku</th>
                        <th id="10"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s10" name="s10" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i10" name="i10" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Harga Sekarang</th>
                        <th id="11"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s11" name="s11" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i11" name="i11" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Harga Sebelumnya</th>
                        <th id="12"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s12" name="s12" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i12" name="i12" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Created at</th>
                        <th id="13"><div class="dropdown">
                            <div class="form-group" style="width: 100px;">
                                <label class="tn">filter</label>
                                <select id="s13" name="s13" class="form-control dpl" onchange="mof(this)">
                                    <option value="none">none</option>
                                    <option value="=">equals</option>
                                    <option value="!=">not equals</option>
                                    <option value=">">greater</option>
                                    <option value=">=">greater equals</option>
                                    <option value="<">less</option>
                                    <option value="<=">less equal</option>
                                    <option value="contain">contains</option>
                                    <option value="not contain">not contains</option>
                                </select>
                                <input type="text" id="i13" name="i13" onkeyup="myf(this)" class="form-control dpl"> 
                            </div>
                        </div>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ib as $data)
                    <tr id="scrow{{$data->id}}" class="trw">
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
                        <td class="ci12">{{$data->created_at}}</td>
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
var objfilter = {i1:[],i2:[],i3:[],i4:[],i5:[],i6:[],i7:[],i8:[],i9:[],i10:[],i11:[],i12:[],i13:[]};
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
function exportexcel() {
    $('#ghost').prop('action', '/export');
    $('#ghost').prop('method', 'get');
    $('#ghost').submit();
}
function mof(self) {
    myf(self.nextElementSibling);
    self.nextElementSibling.value = "";
}

function myf(self) {
    // Declare variables
    let input, id, filter, method, trw, table, tr, td, i, txtValue;
    id = self.id;
    filter = self.value.toUpperCase();
    tr = document.getElementsByClassName("trw");
    method = self.previousElementSibling.value;
    objfilter[id] = [];
    console.log(objfilter[id]);
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByClassName("c"+id)[0];
        tr[i].style.display = "";
        if (filter != ""){
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (parseInt(data === txtValue, 10)) {}
            if (method == "contain") {
                if (!(txtValue.toUpperCase().indexOf(filter) > -1)) {
                    objfilter[id].push(tr[i].id);
                }
            }
            if (method == "not contain") {
                if (!(txtValue.toUpperCase().indexOf(filter) <= -1)) {
                    objfilter[id].push(tr[i].id);
                }
            }
            if (method == "=") {
                if (!(txtValue.toUpperCase() == filter)) {
                    objfilter[id].push(tr[i].id);
                }
            }
            if (method == "!=") {
                if (!(txtValue.toUpperCase() != filter)) {
                    objfilter[id].push(tr[i].id);
                }
            }
            if (method == ">") {
                if (!(txtValue.localeCompare(filter) > 0)) {
                    objfilter[id].push(tr[i].id);
                }
            }

            if (method == ">=") {
                if (!(txtValue.localeCompare(filter) >= 0)) {
                    objfilter[id].push(tr[i].id);
                }
            }

            if (method == "<") {
                if (!(txtValue.localeCompare(filter) < 0)) {
                    objfilter[id].push(tr[i].id);
                }
            }

            if (method == "<=") {
                if (!(txtValue.localeCompare(filter) <= 0)) {
                    objfilter[id].push(tr[i].id);
                }
            }
        }
        }
    }
    let len = tr.length;
    for (let i = 0; i < len; i++) {
        if (tr[i].style.display == ""){
            let vis;
            for(vis in objfilter){
                let ilen = objfilter[vis].length;
                for (let ii = 0; ii < ilen; ii++) {
                    if (objfilter[vis][ii] == tr[i].id) {
                        tr[i].style.display = "none";
                        //console.log(tr[i].id);
                    }
                }
            }
        }
    }
    //console.log(objfilter);
}

</script>
@endpush
@stack('modal')
@endsection