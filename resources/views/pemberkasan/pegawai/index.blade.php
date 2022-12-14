@extends('layouts/main')
@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus fa-sm text-white-50"></i> Add</button>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col">
    @if(session()->has('success'))                                
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <small>{{ session('success') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @elseif(session()->has('failed'))                                
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <small>{{ session('failed') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-header">
                <div class="row d-flex justify-content-end">
                    <div class="col-8 d-flex justify-content-start">
                        <a href="/pemberkasan-pegawai" class="btn btn-primary mr-2"><i class="fas fa-sync fa-sm"></i></a>
                    </div>
                    <div class="col-4">
                        <div class="float-right">
                            <form action="/pemberkasan-pegawai" method="GET">
                                <div class="input-group"> 
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Cari Jenis Berkas</span>
                                    </div>
                                    <select name="search" class="form-control @error('jenis_berkas') is-invalid @enderror" autofocus>
                                        <option value="" selected>--Pilih--</option>
                                        @foreach($jenis_berkas as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" style="text-align: center">
                        <thead>
                            <tr class="bg-primary my-font-white">
                                <th>No</th>
                                <th>Jenis Berkas</th>
                                <th>Keterangan</th>
                                <th>Di Buat</th>
                                <th>Di Ubah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_berkas as $item)
                            <tr>
                                <td>{{ $data_berkas->firstItem() + $loop->index }}</td>
                                <td>{{ $item->jenis_berkas }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>{{ date('d/m/y', strtotime($item->created_at)) }}</td>
                                <td>{{ date('d/m/y', strtotime($item->updated_at)) }}</td>
                                <td>
                                    <a href="{{asset('storage/' . $item->file)}}" class="btn-circle btn-sm btn-primary" target="_blank"><i class="fas fa-eye fa-sm"></i></a>
                                    <form action="/pemberkasan-pegawai/{{ $item->id }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn-circle btn-sm btn-danger border-0" onclick="return confirm('Apakah kamu yakin?')"><i class="fas fa-trash fa-sm"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            {{ $data_berkas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pemberkasan/pegawai/modal/create')
@endsection