@extends('layouts.template')
@section('title', 'Riwayat Transaksi Simpanan')
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
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                        </div>
                    @endif
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (count($transaksiSimpanan) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Type</th>
                                            <th>Nosminal</th>
                                            <th>Saldo Akhir</th>
                                            <th>Petugas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksiSimpanan as $transaksi)
                                        
                                            <tr>
                                                <td>{{ $transaksi->created_at->isoFormat('D MMMM Y, HH:mm:ss') }}</td>
                                                <td>{{ $transaksi->type }}</td>
                                                <td>Rp.{{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                                                <td>Rp.{{ number_format($transaksi->saldo_akhir, 0, ',', '.') }}</td>
                                                <td>{{ $transaksi->pegawai ? $transaksi->pegawai->name : 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <div class="d-flex justify-content-center">
                                    {{ $transaksiSimpanan->links('pagination::bootstrap-4') }}
                                </div>
                            @else
                                <p>Tidak ada riwayat transaksi simpanan.</p>
                            @endif

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
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