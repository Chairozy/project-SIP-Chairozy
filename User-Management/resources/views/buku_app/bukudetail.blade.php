@extends('layouts.app')

@section('title', 'Users | Add')

@section('content')
@push('bgstyle')
<style>
    body, html, #wrapper{
        height: 100%;
    }
    h1 {
        font-size: 1000%;
    }
    .cropped {
        width: 150px;
        height: 150px;
        overflow: hidden;
        border-radius: 50%;
    }

    .cropped img {
        margin: 0px 0px 0px 0px;
    }
</style>
@endpush
@push('enscript')
<script>
let img = new Image();
img.src = $('#jimg').attr("src");
img.onload = function() {
    let val = Math.min(this.width, this.height);
    scale = val / 150;
    nw = this.width / scale;
    nh = this.height / scale;
    $('#jimg').attr('width', nw);
    $('#jimg').attr('height', nh);
}
function bacaGambar(input) {
   if (input.files && input.files[0]) {
      let reader = new FileReader();
 
    reader.onload = function (e) {
        $('#jimg').attr('src', e.target.result);
        img.src = $('#jimg').attr("src");
        img.onload = function() {
            let val = Math.min(this.width, this.height);
            scale = val / 150;
            nw = this.width / scale;
            nh = this.height / scale;
            $('#jimg').attr('width', nw);
            $('#jimg').attr('height', nh);
        }
    }
 
      reader.readAsDataURL(input.files[0]);
   }
}
$("#photo").change(function(){
   bacaGambar(this);
});

function edit() {
    $('#cover').prop('disabled', false);
    $('#pdf').prop('disabled', false);
    $('#judul').prop('disabled', false);
    $('#penerbit').prop('disabled', false);
    $('#terbit').prop('disabled', false);
    $('#pengarang').prop('disabled', false);
    $('#harga').prop('disabled', false);
    $('#jumlah').prop('disabled', false);
    $('#tebal_buku').prop('disabled', false);
    $('#update').replaceWith('<button id="update" type="submit" class="btn btn-success btn-icon-split"> <span class="icon text-white-50"><i id="icon" class="fas fa-check"></i></span><span id="label" class="text">Simpan</span> </button>');
}
</script>
@endpush
<form class="row px-4 py-4 mb-auto" action="/data/buku/update" method="POST" enctype="multipart/form-data">
@csrf
<div class="col-md-4">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Profil User</h6>
        </div>
        <div class="card-body row">
            <div class="form-group col-md-12 mb-auto">
                <label for="cover" class="col-md-12">Gambar Cover</label>
                <div class="cropped mx-auto"><img src="" id="jimg"></div>
                <br>
                <input type="file" accept=".jpg,.jpeg,.png" id="cover" name="cover" class="col-md-12" disabled></input>
            </div>
            <div class="col-md-12">
                <label for="pdf">File pdf</label>
                <input type="file" accept=".jpg,.jpeg,.png" id="pdf" name="pdf" class="col-md-12" disabled></input>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8">
    <div class="card shadow mb-4">
        <div class="card-header navbar static-top py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Informasi</h6>
            @role('Admin')
            <a id="update" class="btn btn-warning btn-icon-split" onclick="edit()">
                <span class="icon text-white-50">
                    <i id="icon" class="fas fa-wrench"></i>
                </span>
                <span id="label" class="text">Edit Data</span>
            </a>
            @endrole
        </div>
        <div class="card-body row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" class="form-control" value="{{$bk->judul}}" disabled>
                    <div class="text-danger">
                        @error('judul')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="pengarang">Pengarang</label>
                    <input type="text" name="pengarang" id="pengarang" class="form-control" value="{{$bk->pengarang}}" disabled>
                    <div class="text-danger">
                        @error('pengarang')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" class="form-control" value="{{$bk->penerbit}}" disabled>
                    <div class="text-danger">
                        @error('penerbit')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="text" id="harga" name="harga" class="form-control" value="{{$bk->harga}}" disabled>
                    <div class="text-danger">
                        @error('harga')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" value="{{$bk->jumlah}}" disabled>
                    <div class="text-danger">
                        @error('jumlah')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="terbit">Tahun Terbit</label>
                    <input type="text" name="terbit" id="terbit" class="form-control" value="{{$bk->terbit}}" disabled>
                    <div class="text-danger">
                        @error('terbit')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="tebal_buku">Tebal Buku</label>
                    <input type="text" name="tebal_buku" id="tebal_buku" class="form-control" value="{{$bk->tebal_buku}}" disabled>
                    <div class="text-danger">
                        @error('tebal_buku')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</form>
@endsection