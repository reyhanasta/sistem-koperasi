@extends('layouts.template')
@section('title', 'Pegawai')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url('pegawai/create/') }}"
                            class="btn btn-primary"><i class="fas fa-plus"></i>
                                <span> Tambah</span></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pegawai</th>
                                        <th>Posisi</th>
                                        <th>Nomor Telefon</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listPegawai as $pegawai)
                                        <tr>
                                            <td>{{ $pegawai->name }}</td>
                                            <td>{{ $pegawai->position }}</td>
                                            <td>{{ $pegawai->phone }}</td>
                                            <td>{{ $pegawai->status }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default">Tindakan</button>
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item" href="{{ url('pegawai/' . $pegawai->id) }}">
                                                            <i class="fas fa-search nav-icon"></i> Detail
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ url('pegawai/' . $pegawai->id . '/edit') }}">
                                                            <i class="fas fa-edit nav-icon"></i> Edit
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ url('pegawai/' . $pegawai->id) }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="dropdown-item"
                                                                onclick="return confirm('Apakah anda sudah yakin ?')">
                                                                <i class="fas fa-trash nav-icon"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach

                                    </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
