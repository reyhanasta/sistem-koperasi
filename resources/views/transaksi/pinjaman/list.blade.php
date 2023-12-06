@extends('layouts.template')
@section('title', 'Transaksi Simpan')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{-- @if (Session::has('success'))
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ Session::get('success') }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                        </div>
                    @endif --}}
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ $urlCreate }}" class="btn btn-primary"><i class="fas fa-plus"></i><span>
                                    Tambah</span></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th width="10px">Nomor Pinjaman</th>
                                        <th>Nama Peminjam</th>
                                        <th width="10px">Tanggal Peminjaman</th>
                                        <th width="10px">Jumlah Pinjaman</th>
                                        <th width="10px">Status Pinjaman</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $index)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $index->kode_pinjaman }}</td>
                                            <td><a
                                                    href="{{ url('nasabah/' . $index->nasabah->id) }}">{{ $index->nasabah->name }}</a>
                                            </td>
                                            <td>{{ $index->created_at->format('d-m-Y') }}</td>
                                            <td>Rp.{{ number_format($index->jumlah_pinjaman) }}</td>
                                            <td>{{ $index->status }}</td>

                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default">Tindakan</button>
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item"
                                                            href="{{ url('trx-pinjaman/' . $index->id) }}"><i
                                                                class="fas fa-search nav-icon"></i> Detail Peminjaman</a>
                                                        @if (auth()->user()->hasRole('admin'))
                                                            <a class="dropdown-item"
                                                                href="{{ url('trx-angsuran/' . $index->id . '/add') }}"><i
                                                                    class="fas fa-edit nav-icon"></i> Edit Pinjaman</a>
                                                            <a class="dropdown-item"
                                                                href="{{ url('trx-angsuran/' . $index->id . '/add') }}"><i
                                                                    class="fas fa-trash nav-icon"></i> Hapus Pinjaman</a>
                                                        @endif
                                                        @if ($index->status !== 'Lunas')
                                                            <form
                                                                action="{{ route('pinjaman.lunasi', ['id' => $index->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PUT') <!-- Ganti dengan PATCH jika sesuai -->
                                                                <button type="submit" class="dropdown-item"
                                                                    href=""><i
                                                                        class="fas fa-cash-register nav-icon"></i> Bayar
                                                                    Lunas
                                                                </button>
                                                            </form>
                                                        @endif


                                                        {{-- <a class="dropdown-item"
                                                            href="{{ url('trx-angsuran/' . $index->id . '/add') }}"><i
                                                                class="fas fa-edit nav-icon"></i> Perpanjang Pinjaman</a> --}}
                                                        {{-- <a class="dropdown-item"
                                                            href="{{ url('trx-angsuran/' . $index->id . '/add') }}"><i
                                                                class="fas fa-edit nav-icon"></i>Status Pengajuan</a> --}}
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
