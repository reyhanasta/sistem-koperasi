@extends('layouts.template')
@section('title', 'Penarikan')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Formulir Transaksi Penarikan</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('penarikan.index') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('transaksi.penarikan._form')
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" onclick="{{ $confirmationMessage }}" class="btn btn-primary">Submit</button>
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
