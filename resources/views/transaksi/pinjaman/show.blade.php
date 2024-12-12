@extends('layouts.template')
@section('title', 'Detail Pinjaman')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="mx-auto col-8">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Pinjaman</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="row">

                                    <div class="col-12 col-sm-12">
                                        <div class="info-box bg-primary">
                                            <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Nominal Pinjaman</span>
                                                <span
                                                    class="info-box-number">Rp.{{ number_format($pinjaman->jumlah_pinjaman) }}</span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="info-box bg-gradient-warning">
                                            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Angsuran</span>
                                                <span
                                                    class="info-box-number">Rp.{{ number_format($pinjaman->angsuran) }}</span>

                                                <div class="progress">
                                                    <div class="progress-bar"
                                                        style="width: {{ $pinjaman->jumlah_angsuran }}%"></div>
                                                </div>
                                                <span class="progress-description">
                                                    Proses angsuran : {{ $pinjaman->jumlah_angsuran }}%
                                                </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-8 invoice-col">
                                        <b>Transaction Code #{{ $pinjaman->kode_pinjaman }}</b>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <h4>
                                            <small class="float-right"> Tanggal :
                                                {{ $pinjaman->created_at->format('d-m-Y') }}</small>
                                        </h4>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 invoice-col">
                                        <b>Nama Peminjam:</b> {{ $pinjaman->nasabah->name }}<br>
                                        <b>Nomor Telepon:</b> {{ $pinjaman->nasabah->phone }}<br>
                                        <b>Alamat:</b> {{ $pinjaman->nasabah->address }}

                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <b>Jenis Usaha:</b> {{ ucwords($pinjaman->jenis_usaha) }}<br>
                                        <br>
                                        <b>Status Pinjaman:</b>
                                        @if ($pinjaman->status === 'lunas')
                                            <span class="badge badge-success">{{ ucwords($pinjaman->status) }}</span>
                                        @elseif($pinjaman->status === 'diproses')
                                            <span class="badge badge-primary">{{ ucwords($pinjaman->status) }}</span>
                                        @elseif($pinjaman->status === 'diajukan')
                                            <span class="badge badge-warning">{{ ucwords($pinjaman->status) }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucwords($pinjaman->status) }}</span>
                                        @endif
                                        <br>
                                        <b>Petugas Transaksi:</b> {{ $pinjaman->pegawai->name }}<br>

                                    </div>
                                    <!-- /.col -->
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="mb-1 text-right col-md-12">
                                        @if ($pinjaman->status == 'diajukan')
                                            <div class="d-flex justify-content-end">
                                                @role('admin')
                                                <form
                                                    action="{{ route('pinjaman.updateStatus', ['id' => $pinjaman->id, 'newStatus' => 'diproses']) }}"
                                                    method="post" class="mr-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">Terima</button>
                                                </form>
                                                <form
                                                    action="{{ route('pinjaman.updateStatus', ['id' => $pinjaman->id, 'newStatus' => 'ditolak']) }}"
                                                    method="post" class="mr-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                                </form>
                                                @endrole
                                                <a href="{{ $previousUrl }}" class="btn btn-sm btn-default">Kembali</a>
                                            </div>
                                        @else
                                            <a href="{{ $previousUrl }}" class="btn btn-sm btn-default">Kembali</a>
                                        @endif


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        </div>

    </section>


@endsection
