@extends('layouts.template')
@section('title', 'Nasabah')
@section('content')
 <!-- Main content -->
 <section class="content">
  <div class="container-fluid">
    {{-- <div class="row">
      <div class="col-lg-3"><a href="#"><i class="fas fa-arrow-left nav-icon"></i> Kembali</a></div>
    </div> --}}
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="../../dist/img/user4-128x128.jpg"
                   alt="User profile picture">
            </div>  
            <h3 class="profile-username text-center">{{$data->name}}</h3>
            <br>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Status</b> <span class="float-right">Aktif</span>
              </li>
            </ul>
            <a href="{{url('customer/'.$data->id.'/edit')}}" class="btn btn-primary btn-block"><b>Ubah Data</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-7">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Profile</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Buku Tabungan</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Riwayat Transaksi</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Pinjaman</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">

              <div class="active tab-pane" id="activity">
                <div class="card-body">
                  <strong><i class="fas fa-book mr-1"></i> Pekerjaan</strong>
                  <p class="text-muted">
                    Wiraswata
                  </p>
                  <hr>
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                  <p class="text-muted"> {{$data->address}}</p>
                  <hr>
                  <strong><i class="fas fa-phone-alt mr-1"></i> Nomor Telephone</strong>
                  <p class="text-muted">
                    {{$data->phone}}
                  </p>
      
                  <hr>
      
                  <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
      
                  <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <div class="card-body">
                  <table id="a" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <td>ID Tabungan</td>
                      <td>{{$dataTabungan->id}}</td>
                    </tr>
                    </thead>
                    <tr>
                      {{-- <td>{{$loop->iteration}}</td> --}}
                      <td>Saldo</td>
                      <td>Rp.{{$dataTabungan->balance}}</td>
                    </td>
                    </tr>                  
                    <tr>
                      {{-- <td>{{$loop->iteration}}</td> --}}
                      <td>Status</td>
                      <td>{{$dataTabungan->status}}</td>
                    </td>
                    </tr>                  
                    <tr>
                      {{-- <td>{{$loop->iteration}}</td> --}}
                      <td>Tanggal Pembuatan</td>
                      <td>{{$dataTabungan->created_at}}</td>
                    </td>
                    </tr>                  
                    </tfoot>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="settings">
               
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-1"></div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
