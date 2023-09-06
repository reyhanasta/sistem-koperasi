@extends('layouts.template')
@section('title', 'Simpanan')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    @error('nasabah')
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title ">Tambahkan Data Nasabah Terlebih Dahulu!</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                        </div>
                    @enderror
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Formulir Transaksi Simpanan</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ url('trx-simpanan') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('transaksi.simpanan._form')
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" onclick="tampilkanModalKonfirmasi()" data-toggle="modal"
                                    data-target="#modal-default" >Submit</button>
                                <a class="btn btn-light" href="{{ $previousUrl }}">Cancel</a>
                            </div>
                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Verifikasi Data</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Pastikan kembali bahwa data yang di inputkan sudah benar </p>
                                            <p><strong>Data yang akan disimpan:</strong></p>
                                            <ul>
                                                <li><span id="dataField1"></span></li>
                                                <li><span id="dataField2"></span></li>
                                                <!-- Tambahkan lebih banyak field sesuai dengan data yang ingin ditampilkan -->
                                            </ul>
                                        </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Batalkan</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection
