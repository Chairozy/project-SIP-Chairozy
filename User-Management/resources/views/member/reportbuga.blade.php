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
<main class="mt-auto p-3 row" role="main">
<div class="col-md-8">
    <div class="card shadow mb-4">
        <div class="card-header navbar static-top py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Keluhan User</h6>
        </div>
        <div class="card-body row">
            <div class="col-lg-7">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}">
                    <div class="text-danger">
                        @error('name')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{old('phone')}}">
                    <div class="text-danger">
                        @error('phone')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                    <div class="text-danger">
                        @error('email')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control" value="{{old('role')}}">
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="form-control" value="{{old('gender')}}">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{old('alamat')}}">
                    <div class="text-danger">
                        @error('alamat')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" value="{{old('tgl_lahir')}}">
                    <div class="text-danger">
                        @error('tgl_lahir')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="kebangsaan">Kebangsaan</label>
                    <input type="text" name="kebangsaan" id="kebangsaan" class="form-control" value="{{old('kebangsaan')}}">
                </div>
            </div>

            <div class="col">
            <button type="submit" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text">Laporkan</span>
            </button>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Dari User</h6>
        </div>
        <div class="card-body row">
            <div class="form-group col-md-12 mb-auto">
                <div class="cropped mx-auto"><img src="" id="jimg"></div>
            </div>
            <div class="col-md-12">
                <h3 class="text-center">{{$ct->name}}</h3>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
