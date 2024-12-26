@extends('layouts.template')
@section('title', 'Transaksi Simpan')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (Session::has('success'))
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
                @endif
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(count($riwayatSimpanan) > 0)
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kode Simpanan</th>
                                    <th>Type</th>
                                    <th>Jumlah</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatSimpanan as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->created_at->isoFormat('D MMMM Y, HH:mm:ss') }}</td>
                                        <td>{{ $transaksi->kode_simpanan }}</td>
                                        <td>{{ $transaksi->type }}</td>
                                        <td>{{ $transaksi->amount }}</td>
                                        <td>{{ $transaksi->desc }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Tidak ada riwayat transaksi simpanan.</p>
                    @endif
                        <a href="{{ $previousUrl }}" class="btn btn-secondary">Kembali</a>
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
