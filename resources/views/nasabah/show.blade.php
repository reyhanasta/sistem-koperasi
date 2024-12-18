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
                        <h3 class="text-center profile-username">{{ $data->name }}</h3>
                        <p class="text-center text-muted">NIK {{ $data->ktp }}</p>
                        <ul class="mb-3 list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Status</b>
                                <span
                                    class="float-right @if ($dataTabungan->status === 'aktif') text-success @else text-danger @endif">
                                    Aktif
                                </span>


                            </li>


                        </ul>

                        <a href="{{ route('riwayatTransaksi', ['nasabah_id' => $data->id]) }}"
                            class="btn btn-info btn-block">
                            <i class="mr-1 fas fa-list"></i>
                            <b>Daftar Mutasi</b>
                        </a>
                        <a href="{{ route('pinjaman.riwayat', ['nasabah_id' => $data->id]) }}"
                            class="btn btn-primary btn-block"><b>
                                <i class="mr-1 fas fa-tasks"></i>
                                Daftar Peminjaman</b></a>
                        <hr>
                        <a href="{{ url('nasabah/' . $data->id . '/edit') }}" class="btn btn-warning btn-block">
                            <i class="mr-1 fas fa-user-cog"></i>
                            <b>Update Data Nasabah</b>
                        </a>
                    </div>
                    <!-- /.card-body -->
                </div>

                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-7">
                <div class="card">
                    <div class="p-2 card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity"
                                    data-toggle="tab">Profile</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Buku
                                    Tabungan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#berkas" data-toggle="tab">Berkas Nasabah</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <div class="card-body">
                                    <strong><i class="mr-1 fas fa-calendar"></i> Tanggal Lahir</strong>
                                    <p class="text-muted">
                                        {{ date('d-m-Y', strtotime($data->date_of_birth)) }} ({{ $age }} Tahun)

                                    </p>
                                    <hr>
                                    <strong><i class="mr-1 fas fa-phone-alt"></i> Nomor Telephone</strong>
                                    <p class="text-muted">
                                        {{ $data->phone }}
                                    </p>
                                    <hr>
                                    <strong><i class="mr-1 fas fa-map-marker-alt"></i> Alamat</strong>
                                    <p class="text-muted"> {{ $data->address }}</p>

                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                <div class="card-body">
                                    <table id="table-rekening" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>{{ $dataTabungan->no_rek }}</td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            {{-- <td>{{$loop->iteration}}</td> --}}
                                            <td>Saldo</td>
                                            <td>Rp.{{ number_format($dataTabungan->balance) }}</td>
                                            </td>
                                        </tr>
                                        <tr>
                                            {{-- <td>{{$loop->iteration}}</td> --}}
                                            <td>Status</td>
                                            <td>
                                                @if ($dataTabungan->status === 'aktif')
                                                <span style="color: green;">{{ ucwords($dataTabungan->status) }}</span>
                                                @else
                                                <span style="color: red;">{{ ucwords($dataTabungan->status) }}</span>
                                                @endif
                                            </td>

                                        </tr>
                                        <tr>
                                            {{-- <td>{{$loop->iteration}}</td> --}}
                                            <td>Tanggal Pembuatan</td>
                                            <td>{{ $dataTabungan->created_at->isoFormat('D MMMM Y, HH:mm:ss') }}
                                            </td>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="berkas">
                                <div class="card-body">
                                    <strong><i class="mr-1 fas fa-user"></i>KTP Nasabah</strong>

                                    {{-- Kode Menampilkan KTP --}}
                                    @if ($data->ktp_image_path)
                                    <div class="ktp">
                                        <br>
                                        <a href="{{ asset('storage/ktp_images/' . $data->ktp_image_path) }}"
                                            data-toggle="lightbox" data-title="KTP" data-gallery="gallery">
                                            <img src="{{ asset('storage/ktp_images/' . $data->ktp_image_path) }}"
                                                class="mb-2 img-fluid" alt="Foto Identitas Nasabah" width="50%"
                                                height="50%" />

                                        </a>
                                    </div>
                                    @else
                                    <p>Gambar KTP Nasabah tidak tersedia.</p>
                                    @endif
                                    <hr>
                                </div>
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