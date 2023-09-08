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
                <li class="list-group-item"><strong>ID Pinjaman:</strong> {{ $pinjaman->id }}</li>
                <li class="list-group-item"><strong>ID Anggota:</strong> <a href="{{ url('nasabah/'.$pinjaman->id_nasabah)}}">{{ $pinjaman->id_nasabah }}</a></li>
                <li class="list-group-item"><strong>Tanggal Pengajuan:</strong> {{ $pinjaman->tanggal_pengajuan }}</li>
                <li class="list-group-item"><strong>Jumlah Pinjaman:</strong> Rp.{{ number_format($pinjaman->jumlah_pinjaman) }}</li>
                <li class="list-group-item"><strong>Jenis Pinjaman:</strong> {{ $pinjaman->jenis_pinjaman }}</li>
                <li class="list-group-item"><strong>Tujuan Pinjaman:</strong> {{ $pinjaman->tujuan_pinjaman }}</li>
                <li class="list-group-item"><strong>Jangka Waktu (bulan):</strong> {{ $pinjaman->jangka_waktu }}</li>
                <li class="list-group-item"><strong>Bunga (%):</strong> {{ $pinjaman->bunga }}</li>
                <li class="list-group-item"><strong>Metode Pembayaran:</strong> {{ $pinjaman->metode_pembayaran }}</li>
                <li class="list-group-item"><strong>Catatan:</strong> {{ $pinjaman->catatan ?? 'Tidak ada catatan' }}</li>
            </div>
            <div class="text-center mt-3">
                <a href="{{$previousUrl}}" class="btn btn-secondary">Kembali</a>
                <a href="" class="btn btn-success">Terima Pinjaman</a>
                <a href="" class="btn btn-primary">Lakukan Angsuran</a>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection