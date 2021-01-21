@extends('layouts.basictemp')

@section('title', 'Users')

@section('content')
@push('detailscript')
<script type="text/javascript">
    function edit() {
        $('#name').prop('disabled', false);
        $('#username').prop('disabled', false);
        $('#email').prop('disabled', false);
        $('#role').prop('disabled', false);
        $('#password').prop('disabled', false);
        $('#password').prop('value', '');
        $('#c_password').prop('disabled', false);
        $('#c_password').prop('value', '');
        $('#update').replaceWith('<button id="update" type="submit" class="btn btn-success btn-icon-split"> <span class="icon text-white-50"><i id="icon" class="fas fa-check"></i></span><span id="label" class="text">Simpan</span> </button>');
    }
</script>
@endpush
<div class="card shadow mb-4">
    <form action="/update" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-header navbar static-top py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Informasi</h6>
        <a id="update" class="btn btn-warning btn-icon-split" onclick="edit()">
            <span class="icon text-white-50">
                <i id="icon" class="fas fa-wrench"></i>
            </span>
            <span id="label" class="text">Edit Data</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4"></div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$ct->name}}" disabled>
                        <div class="text-danger">
                            @error('name')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{$ct->username}}" disabled>
                        <div class="text-danger">
                            @error('username')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{$ct->email}}" disabled>
                        <div class="text-danger">
                            @error('email')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col col-lg-2">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control" disabled>
                            <option <?php if($ct->role_id == "User") echo 'SELECTED' ?> value="User">User</option>
                            <option <?php if($ct->role_id == "Admin") echo 'SELECTED' ?> value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="{{$ct->password}}" disabled>
                        <div class="text-danger">
                            @error('password')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="c_password">Confirm Password</label>
                        <input type="password" name="c_password" id="c_password" class="form-control" value="{{$ct->password}}" disabled>
                        <div class="text-danger">
                            @error('c_password')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection