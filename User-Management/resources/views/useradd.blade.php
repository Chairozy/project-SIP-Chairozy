@extends('layouts.basictemp')

@section('title', 'Users | Add')

@section('content')
<div class="card shadow mb-4">
    <form action="/user/send" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-header navbar static-top py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Pengisian / Penambahan User</h6>
            <button type="submit" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text">Tambahkan</span>
            </button>
        </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="row">
                <div class="col">
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
                <div class="col">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{old('usernama')}}">
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
                        <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
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
                        <select id="role" name="role" class="form-control" value="{{old('role')}}">
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
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
                        <input type="password" name="c_password" id="c_password" class="form-control">
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