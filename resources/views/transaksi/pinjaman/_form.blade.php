<div class="card-body">
    <div class="form-group ">
        <label>Data Nasabah</label>
        @if ($nasabahList->count() > 0)
            <select class="form-control" name="nasabah">
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
        <input type="date" class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan" required>
    </div>
    <div class="form-group">
        <label for="jumlah_pinjaman">Jumlah Pinjaman</label>
        <input type="number" class="form-control" name="jumlah_pinjaman" id="jumlah_pinjaman" required>
    </div>
    <div class="form-group">
        <label for="jenis_pinjaman">Jenis Pinjaman</label>
        <select class="form-control" name="jenis_pinjaman" id="jenis_pinjaman" required>
            <option value="pribadi">Pribadi</option>
            <option value="usaha">Usaha</option>
            <!-- Tambahkan pilihan jenis pinjaman lainnya sesuai kebutuhan -->
        </select>
    </div>
    <div class="form-group">
        <label for="tujuan_pinjaman">Tujuan Pinjaman</label>
        <input type="text" class="form-control" name="tujuan_pinjaman" id="tujuan_pinjaman" required>
    </div>
    <div class="form-group">
        <label for="jangka_waktu">Jangka Waktu (bulan)</label>
        <input type="number" class="form-control" name="jangka_waktu" id="jangka_waktu" required>
    </div>
    <div class="form-group">
        <label for="bunga">Bunga (%)</label>
        <input type="number" class="form-control" name="bunga" id="bunga" required>
    </div>
    <div class="form-group">
        <label for="catatan">Catatan (Opstional)</label>
        <input type="number" class="form-control" name="catatan" id="catatan" >
    </div>
</div>
