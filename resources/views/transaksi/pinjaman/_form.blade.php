<div class="card-body">
    <div class="form-group ">
        <label>Data Nasabah</label>
        @if ($nasabahList->count() > 0)
            <select class="form-control select2" style="width: 100%;" id="selectNasabah" name="nasabah">
                <option value="" disabled selected>Pilih Nasbah</option>
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
        <input type="date" class="form-control @if ($errors->has('tanggal_pengajuan')) is-invalid @endif"
            name="tanggal_pengajuan" id="tanggal_pengajuan"
            value="{{ old('tanggal_pengajuan', now()->format('Y-m-d')) }}" required>
    </div>
    <div class="form-group">
        <label for="jumlah_pinjaman">Jumlah Pinjaman</label>
        {{-- <input type="text" class="form-control @if ($errors->has('jumlah_pinjaman')) is-invalid @endif"
            name="jumlah_pinjaman" value="{{ old('jumlah_pinjaman') }}" id="jumlah_pinjaman" required data-mask> --}}
        <select class="form-control select2 
        @if ($errors->has('jumlah_pinjaman')) is-invalid 
        @endif" name="jumlah_pinjaman"
            id="jumlah_pinjaman">
            <?php
            // Tambahkan angka kelipatan 1.000.000 ke dropdown
            for ($i = 1; $i <= 30; $i++) {
                $value = $i * 1000000; // Hitung nilai kelipatan
                echo "<option value=\"$value\">Rp " . number_format($value, 0, ',', '.') . '</option>';
            }
            ?>
        </select>

        @error('jumlah_pinjaman')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="jenis_pinjaman">Jenis Usaha</label>
        <input type="text" class="form-control"id="jenis_usaha" name="jenis_usaha"
            value="{{ old('jenis_usaha') }}"id="">
        @error('jenis_usaha')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="jangka_waktu">Jangka Waktu Pembayaran</label>
        <div class="input-group">
            <input type="number" class="form-control" name="jangka_waktu" id="jangka_waktu" value="100" readonly>
            <div class="input-group-append">
                <span class="input-group-text">Kali</span>
            </div>
        </div>
    </div>
    {{-- <div class="form-group">
        <label for="bunga">Bunga (%)</label>
        <div class="input-group">
            <input type="number" class="form-control" name="bunga" id="bunga" value="0"required>
            <div class="input-group-append">
                <span class="input-group-text">%</span>
            </div>
        </div>
    </div> --}}
    <div class="form-group">
        <label for="catatan">Catatan (Opstional)</label>
        <textarea name="catatan" id="catatan" cols="30" rows="3" class="form-control"></textarea>
    </div>
</div>