@extends('layouts.template')
@section('title', 'Pegawai')
@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              @if(strlen($dataPegawai->profile_pict) > 0)
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{asset('picture/'.$dataPegawai->profile_pict)}}"
                     alt="User profile picture">
              </div>
              @else
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="../../dist/img/user4-128x128.jpg"
                     alt="User profile picture">
              </div>
              @endif
      
              <h3 class="text-center profile-username">{{$dataPegawai->name}}</h3>
              <p class="text-center text-muted">NIK</p>
              
              <ul class="mb-3 list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Posisi</b> <span class="float-right">{{$dataPegawai->position}}</span>
                </li>
                <li class="list-group-item">
                  <b>Salary</b> <span class="float-right">{{$salary}}</span>
                </li>
                <li class="list-group-item">
                  <b>Bergabung pada</b> <span class="float-right">{{$joindate}}</span>
                </li>
                <li class="list-group-item">
                  <b>Status Pegawai</b> <a class="float-right">{{$dataPegawai->status}}</a>
                </li>
              </ul>

              <a href="{{url('pegawai/'.$dataPegawai->id.'/edit')}}" class="btn btn-primary btn-block"><b>Edit Data</b></a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-lg-6">
           <!-- About Me Box -->
           <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Data Pribadi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="mr-1 fas fa-venus-mars"></i> Jenis Kelamin</strong>
              <p class="text-muted">{{$gender}}</p>
              <hr>
              <strong><i class="mr-1 fas fa-envelope"></i> Alamat Email</strong>
              <p class="text-muted">{{$dataPegawai->email}}</p>
              <hr>
              <strong><i class="mr-1 fas fa-map-marker-alt"></i> Alamat Rumah</strong>
              <p class="text-muted">{{$dataPegawai->address}}</p>
              <hr>
              <strong><i class="mr-1 fas fa-phone-alt"></i> Contact</strong>
              <p class="text-muted">{{$dataPegawai->phone}}</p>
              <hr>
              <strong><i class="mr-1 far fa-file-alt"></i> Notes</strong>
              <p class="text-muted">{{$desc}}</p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
