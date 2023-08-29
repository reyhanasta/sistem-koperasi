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
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
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
                        <form action="{{ url('trx-pinjaman') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('transaksi.pinjaman._form')
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" onclick="{{ $confirmMessage }}" class="btn btn-primary">Submit</button>
                                <a class="btn btn-light" href="{{ $previousUrl }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection
