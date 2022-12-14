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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-8 d-flex justify-content-start">
                    <a href="/cuti" class="btn btn-primary"><i class="fas fa-sync fa-sm"></i></a>
                    <a href="/export/cuti/" class="btn btn-success ml-1" target="_blank"><i class="fas fa-file-excel fa-sm"></i></a>
                    <a href="/report/cuti/" class="btn btn-danger ml-1" target="_blank"><i class="fas fa-file-pdf fa-sm"></i></a>
                </div>
                <div class="col-4">
                    <form action="/cuti" method="GET">
                        <div class="input-group"> 
                            <input type="text" class="form-control small" placeholder="Cari.." name="search" value="{{ request('search') }}">
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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-primary my-font-white">
                            <th>No</th>
                            <th>NIP</th>
                            <th>Jenis Cuti</th>
                            <th>Tanggal Cuti</th>
                            <th>Tanggal Selesai</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_cuti as $item)
                        <tr>
                            <td>{{ $data_cuti->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->jenis_cuti }}</td>
                            <td>{{ $item->tanggal_cuti }}</td>
                            <td>{{ $item->tanggal_masuk }}</td>
                            <td  style="text-align: center">
                                @if(date('Y-m-d') >= $item->tanggal_masuk)
                                <div class="badge badge-success">Selesai</div>
                                @else
                                <?php
                                    $tgl_sekarang = new DateTime(date('Y-m-d'));
                                    $tgl_masuk = new DateTime($item->tanggal_masuk);
                                    $selisih = $tgl_sekarang->diff($tgl_masuk);
                                ?>
                                <div class="badge badge-light">Sisa : {{ $selisih->d }} Hari</div>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <button class="btn-circle btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $item->id }}"><i class="fas fa-eye fa-sm"></i></button>
                                <form action="/bidang/{{ $item->id }}" method="post" class="d-inline">
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
                        {{ $data_cuti->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@include('cuti/modal/create')
@include('cuti/modal/show')

@endsection