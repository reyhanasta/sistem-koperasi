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
                                <h3 class="card-title">Tambahkan Data Nasabah Terlebih Dahulu!</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    @enderror
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Formulir Transaksi Simpanan</h3>
                        </div>
                        {{-- Form  --}}
                        <form action="{{ url('trx-simpanan') }}" method="post" id="form-simpanan" enctype="multipart/form-data">
                            @csrf
                            @include('transaksi.simpanan._form')
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" onclick="tampilkanModalKonfirmasiSimpanan()"
                                    data-toggle="modal" data-target="#modal-default">
                                    Submit
                                </button>
                                <a class="btn btn-light" href="{{ $previousUrl }}">Cancel</a>
                            </div>

                            {{-- Modal --}}
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
                                            <p>Pastikan kembali bahwa data yang diinputkan sudah benar.</p>
                                            <p><strong>Data yang akan disimpan:</strong></p>
                                            <table border="0" >
                                                <tr>
                                                    <td>Kode Transaksi</td>
                                                    <td>:</td>
                                                    <td><span id="modal-kode"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Nasabah</td>
                                                    <td>:</td>
                                                    <td><span id="modal-nasabah"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah Simpanan</td>
                                                    <td>:</td>
                                                    <td><span id="modal-jumlah"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Tipe Simpanan</td>
                                                    <td>:</td>
                                                    <td><span id="modal-type"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Info Tambahan</td>
                                                    <td>:</td>
                                                    <td><span id="modal-desc"></span></td>
                                                </tr>
                                            </table>
                                            
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Batalkan</button>
                                            <button type="submit" id="simpanButton" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
