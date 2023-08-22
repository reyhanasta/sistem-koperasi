@extends('layouts.template')
@section('title', 'Nasabah')
@section('content')

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-5">
            <div class="card card-primary">
              <div class="card-header">
                  <h3 class="card-title">Formulir Nasabah</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ url('customer/' . $data->id) }}" method="post" enctype="multipart/form-data">
                  @method('put')
                  {{ csrf_field() }}
                  @include('nasabah._form')
                  <!-- /.card-body -->
                  <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a class="btn btn-light" href="{{ $back }}">Cancel</a>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
        
    </section>
@endsection
