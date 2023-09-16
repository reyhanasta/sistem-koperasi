<div class="card-body">
    <div class="form-group ">
        <label>Data Nasabah</label>
        @if ($nasabahList->count() > 0)
            <select class="form-control" name="nasabah" id="nasabah">
                <!--NANTI AKAN MENGGUNAKAN DATA MASTER JABATAN-->
                @foreach ($nasabahList as $x)
                    <option value={{ $x->id }}>{{ $x->id }} - {{ $x->name }}</option>
                @endforeach
            </select>
        @else
            <a class="form-control btn btn-success" href="{{ url('nasabah/create/') }}" class="btn btn-primary"><i
                    class="fas fa-plus"></i><span> Tambah Data Nasabah</span></a>
        @endif
    </div>
    <div class="form-group">
        <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
        <input type="date" class="form-control " name="tanggal_pengajuan" id="tanggal_pengajuan" value="{{ now()->format('Y-m-d')}}" required>
        @if ($errors->has('amount'))
            <div class="text-danger">Minimal Transaksi Rp.5.000</div>
        @endif
    </div>
    <div class="form-group">
        <label for="jumlah_pinjaman">Jumlah Pinjaman</label>
        <input type="text" class="form-control @if ($errors->has('jumlah_pinjaman')) is-invalid @endif"
            name="jumlah_pinjaman" id="jumlah_pinjaman" required data-mask>
    </div>
    @if ($errors->has('jumlah_pinjaman'))
        <div class="text-danger">Minimal Transaksi Peminjaman Rp.5.000</div>
    @endif

    <div class="form-group">
        <label for="jenis_pinjaman">Jenis Pinjaman</label>
        <select class="form-control" name="jenis_pinjaman" id="jenis_pinjaman" required>
            <option value="usaha">Usaha</option>
            <option value="pribadi">Pribadi</option>
            <!-- Tambahkan pilihan jenis pinjaman lainnya sesuai kebutuhan -->
        </select>
    </div>
    <div class="form-group">
        <label for="tujuan_pinjaman">Tujuan Pinjaman</label>
        <input type="text" class="form-control" name="tujuan_pinjaman" id="tujuan_pinjaman" required>
    </div>
    <div class="form-group">
        <label for="jangka_waktu">Jangka Waktu (bulan)</label>
        <div class="input-group">
            <input type="number" class="form-control" name="jangka_waktu" id="jangka_waktu" required>
            <div class="input-group-append">
                <span class="input-group-text">Bulan</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="bunga">Bunga (%)</label>
        <div class="input-group">
            <input type="number" class="form-control" name="bunga" id="bunga" value="0"required>
            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="catatan">Catatan (Opstional)</label>
        <textarea name="catatan" id="catatan" cols="30" rows="3" class="form-control"></textarea>
    </div>
</div>
