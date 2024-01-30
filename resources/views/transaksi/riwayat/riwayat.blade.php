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
                            @if (count($riwayatTransaksi) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Type</th>
                                            <th>Nominal</th>
                                            <th>Saldo Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatTransaksi as $transaksi)
                                            <tr>
                                                <td>{{ $transaksi->created_at->isoFormat('D MMMM Y, HH:mm:ss') }}</td>
                                                <td>{{ $transaksi->type }}</td>
                                                <td>Rp.{{ number_format($transaksi->nominal) }}</td>
                                                <td>Rp.{{ number_format($transaksi->saldo_akhir) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <div class="d-flex justify-content-center">
                                    {{ $riwayatTransaksi->links('pagination::bootstrap-4') }}
                                </div>
                                <a href="{{ $previousUrl }}" class="btn btn-secondary">Kembali</a>

                            @else
                                <p>Tidak ada riwayat transaksi simpanan.</p>
                            @endif



                        </div>
                        {{-- <a href="{{ $previousUrl }}" class="btn btn-secondary">Kembali</a> --}}
                        <!-- /.card-body -->
                        <!-- Tambahkan kode pagination berikut -->


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
