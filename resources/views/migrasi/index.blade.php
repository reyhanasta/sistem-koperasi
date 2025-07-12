@extends('layouts.template')
@section('title','Migrasi Data SQL')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Formulir Jabatan BTM</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('migrasi.upload') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include('migrasi._form')
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-light" href="{{$back}}">Cancel</a>
                        </div>
                    </form>

                    <hr class="my-6">

                    <form action="{{ route('migrasi.nasabah') }}" method="POST">
                        @csrf
                        <button class="w-full px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700"
                            type="submit">Migrasikan Data Nasabah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
@endsection