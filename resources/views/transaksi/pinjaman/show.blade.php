@extends('layouts.template')
@section('title', 'Nasabah')
@section('content')
    <div class="container mt-5">
        <h1>Detail Pinjaman</h1>
        <hr>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-5">
                <div class="list-group">
                    {{-- <li class="list-group-item"><strong>ID Pinjaman:</strong> {{ $pinjaman->id }}</li> --}}
                    <li class="list-group-item"><strong>Kode Pinjaman:</strong> {{ $pinjaman->kode_pinjaman }}</li>
                    <li class="list-group-item"><strong>ID Anggota:</strong> <a
                            href="{{ url('nasabah/' . $pinjaman->id_nasabah) }}">{{ $pinjaman->id_nasabah }}</a></li>
                    <li class="list-group-item"><strong>Tanggal Pengajuan:</strong> {{ $pinjaman->tanggal_pengajuan }}</li>
                    <li class="list-group-item"><strong>Jumlah Pinjaman:</strong>
                        Rp.{{ number_format($pinjaman->jumlah_pinjaman) }}</li>
                    <li class="list-group-item"><strong>Jenis Pinjaman:</strong> {{ ucwords($pinjaman->jenis_pinjaman) }}
                    </li>
                    <li class="list-group-item"><strong>Tujuan Pinjaman:</strong> {{ ucwords($pinjaman->tujuan_pinjaman) }}
                    </li>
                    <li class="list-group-item"><strong>Jangka Waktu (bulan):</strong> {{ $pinjaman->jangka_waktu }}</li>
                    <li class="list-group-item"><strong>Bunga (%):</strong> {{ $pinjaman->bunga }}</li>
                    <li class="list-group-item"><strong>Metode Pembayaran:</strong>
                        {{ ucwords($pinjaman->metode_pembayaran) }}</li>
                    <li class="list-group-item"><strong>Catatan:</strong> {{ $pinjaman->catatan ?? 'Tidak ada catatan' }}
                    </li>
                    <li class="list-group-item"><strong>Status:</strong>
                        <span
                            class="badge
                            {{ $pinjaman->status === 'Disetujui'
                                ? 'bg-success'
                                : ($pinjaman->status === 'Lunas'
                                    ? 'bg-success'
                                    : ($pinjaman->status === ' Diajukan'
                                        ? 'bg-warning'
                                        : ($pinjaman->status === 'Proses Angsuran'
                                            ? 'bg-info'
                                            : ($pinjaman->status === 'Ditolak'
                                                ? 'bg-danger'
                                                : '')))) }}">
                            {{ ucwords($pinjaman->status) }}
                        </span>
                    </li>
                    </li>
                </div>
                <div class="text-center mt-3">

                    @if ($pinjaman->status == 'Diajukan')
                        @if (auth()->user()->hasRole('admin'))
                            <form
                                action="{{ route('pinjaman.updateStatus', ['id' => $pinjaman->id, 'newStatus' => 'Disetujui']) }}"
                                method="POST">
                                @csrf
                                @method('PUT') <!-- Ganti dengan PATCH jika sesuai -->
                                <a href="{{ $previousUrl }}" class="btn btn-secondary">Kembali</a>
                                <button class="btn btn-success" type="submit">Setujui Pinjaman</button>
                            </form>
                        @else
                            <a href="{{ $previousUrl }}" class="btn btn-secondary">Kembali</a>
                            <button class="btn btn-info">Menunggu Persetujuan</button>
                        @endif
                    @else
                        <a href="{{ $previousUrl }}" class="btn btn-secondary">Kembali</a>
                        <button type="button" class="btn btn-primary" onclick="tampilkanModalAngsuran()"
                            data-toggle="modal" data-target="#modal-default">
                            Lakukan Angsuran
                        </button>
                    @endif
                </div>

            </div>
        </div>
        <br>
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
                    <form action="{{ url('trx-angsuran') }}" method="POST">
                        @csrf
                        <table border="0">
                            <tr>
                                <td>Kode Transaksi</td>
                                <td><input type="text" name="kode_transaksi" id="modal-kode"
                                        value="{{ $pinjaman->kode_pinjaman }}" readonly class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Nama Nasabah</td>
                                <td><input type="text" name="nama_nasabah" id="modal-nasabah"
                                        value="{{ $pinjaman->nasabah->nama }}" readonly class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Total Tagihan</td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="jumlah_simpanan" id="modal-jumlah-bayar"
                                            value="{{ number_format($pinjaman->total_pembayaran) }}" readonly
                                            class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Angsuran</td>
                                <td>
                                <td class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="angsuran" id="modal-jumlah-angsuran"
                                        value="{{ number_format($pinjaman->angsuran) }}" readonly class="form-control">
                                </td>
                </div>
                </tr>
                <tr>
                    <td>Angsuran ke </td>
                    <td>
                        <div class="input-group">
                            <input type="number" name="jumlah_angsuran" required class="form-control"
                                value="{{ $pinjaman->jumlah_angsuran + 1 }}" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">/ {{ $pinjaman->jangka_waktu }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <input type="hidden" name="id_pinjaman" value="{{ $pinjaman->id }}">
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batalkan</button>
                <button type="submit" id="simpanButton" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
