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
        <a href="/user/add" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Pengguna</span>
        </a>
        @endrole
    </div>
    <div class="card-body">
        <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="align-middle w-40">Username</th>
                            <th class="align-middle w-40">Role</th>
                            <th class="align-middle w-200">Name</th>
                            <th class="align-middle w-40">Email</th>
                            <th class="align-middle w-20">Created At</th>
                            <th class="align-middle w-20">Updated At</th>
                            <th class="align-middle w-30">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all as $data)
                        <tr role="row" class="odd">
                            <td>{{$data->username}}</a></td>
                            <td>{{$data->role_id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <td>
                            <div class="btn-group">
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
        </div>
    </div>
</div>
</div>
@stack('modal')
@endsection