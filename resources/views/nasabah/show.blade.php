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
                            <h3 class="profile-username text-center">{{ $data->name }}</h3>
                            <p class="text-muted text-center">NIK {{ $data->ktp }}</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b>
                                    <span
                                        class="float-right @if ($dataTabungan->status === 'aktif') text-success @else text-danger @endif">
                                        Aktif
                                    </span>
                                </li>
                            </ul>
                            <a href="{{ url('nasabah/' . $data->id . '/edit') }}" class="btn btn-primary btn-block"><b>Ubah
                                    Data</b></a>
                            <a href="{{ route('riwayatTransaksi', ['nasabah_id' => $data->id]) }}"
                                class="btn btn-info btn-block"><b>Riwayat Transaksi</b></a>
                            <a href="{{ route('pinjaman.riwayat', ['nasabah_id' => $data->id]) }}"
                                class="btn btn-warning btn-block"><b>Riwayat Pinjaman</b></a>
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
                                        <strong><i class="fas fa-calendar mr-1"></i> Tanggal Lahir</strong>
                                        <p class="text-muted">
                                            {{ date('d-m-Y', strtotime($data->date_of_birth)) }} ({{ $age }} Tahun)

                                        </p>
                                        <hr>
                                        <strong><i class="fas fa-phone-alt mr-1"></i> Nomor Telephone</strong>
                                        <p class="text-muted">
                                            {{ $data->phone }}
                                        </p>
                                        <hr>
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
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
                                                        <span
                                                            style="color: green;">{{ ucwords($dataTabungan->status) }}</span>
                                                    @else
                                                        <span
                                                            style="color: red;">{{ ucwords($dataTabungan->status) }}</span>
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
                                        <strong><i class="fas fa-user mr-1"></i>KTP Nasabah</strong>
                                       
                                        {{-- Kode Menampilkan KTP --}}
                                        @if ($data->ktp_image_path)
                                            <div class="ktp">
                                                <br>
                                                <a href="{{ asset('storage/ktp_images/' . $data->ktp_image_path) }}"
                                                    data-toggle="lightbox" data-title="KTP"
                                                    data-gallery="gallery">
                                                    <img src="{{ asset('storage/ktp_images/' . $data->ktp_image_path) }}"
                                                        class="img-fluid mb-2" alt="Foto Identitas Nasabah" width="50%"
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
