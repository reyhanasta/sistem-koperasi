@extends('layouts.template')
@section('title', 'Transaksi Simpan')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{-- @if (Session::has('success'))
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ Session::get('success') }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                        </div>
                    @endif --}}
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('penarikan.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i><span> Tambah</span></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Transaksi</th>
                                        <th>Nama Nasabah</th>
                                        <th>Jumlah Penarikan</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Deskripsi</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index)
                                 
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $index->kode_simpanan }}
                                            </td>
                                            <td><a
                                                href="{{ url('nasabah/' . $index->nasabah->nasabah_id) }}">
                                                {{ $index->nasabah->name }}
                                            </a></td>
                                            <td>Rp.{{ number_format($index->amount) }}</td>
                                            <td>{{ $index->created_at->isoFormat('D MMMM Y, HH:mm:ss') }}</td>
                                            <td>{{ $index->desc }}</td>
                                            {{-- <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default">Tindakan</button>
                      <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="{{ url('tr-withdraw/'.$index->id)}}"><i class="fas fa-search nav-icon"></i> Detail</a>
                        <a class="dropdown-item" href="{{ url('tr-withdraw/'.$index->id.'/edit')}}"><i class="fas fa-edit nav-icon"></i> Edit</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ url('tr-withdraw/'.$index->id)}}" method="post">
                          @method('delete')
                          @csrf
                          <button type="submit" class="dropdown-item" onclick="return confirm('Apakah anda sudah yakin ?')"> <i class="fas fa-trash nav-icon"></i> Delete</button>
                        </form>
                      </div>
                    </div>
                  </td> --}}
                                        </tr>
                                    @endforeach

                                    </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
