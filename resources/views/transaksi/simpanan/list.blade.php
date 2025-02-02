@extends('layouts.template')
@section('title', 'Transaksi Simpan')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('simpanan.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i><span> Tambah</span></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Simpanan</th>
                                        <th>Nama Nasabah</th>
                                        <th>Jumlah Simpanan</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $index)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $index->kode_simpanan }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('nasabah.show', $index->nasabah_id) }}">{{ $index->nasabah->name }}</a>
                                            </td>
                                            <td>Rp.{{ number_format($index->amount) }}</td>
                                            <td>{{ $index->created_at->isoFormat('D MMMM Y, HH:mm:ss') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default">Tindakan</button>
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        @role('admin')
                                                            {{-- <a class="dropdown-item"
                                                                href="{{ url('trx-simpanan/' . $index->id . '/edit') }}"><i
                                                                    class="fas fa-edit nav-icon"></i> Edit</a>
                                                            <div class="dropdown-divider"></div> --}}
                                                            <form action="{{ url('trx-simpanan/' . $index->id) }}"
                                                                method="post">
                                                                @method('delete')
                                                                @csrf
                                                                {{-- <button type="submit" class="dropdown-item" id="deleteData">
                                                                    <i class="fas fa-trash nav-icon"></i> Delete </button> --}}
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Apakah anda sudah yakin ?')">
                                                                    <i class="fas fa-trash nav-icon"></i> Delete</button>
                                                            </form>
                                                        @endrole
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
