<div class="card-body">
    <div class="form-group">
        <label for="kode">Kode Transaksi</label>
        <input class="form-control" type="text" name="kode" id="kode" value="{{ $kodeInput }}" readonly>
    </div>
    <div class="form-group">
        <label>Data Nasabah</label>
        <select class="form-control @error('nasabah') is-invalid @enderror" name="nasabah" id="nasabah">
            @foreach ($nasabahList as $x)
                <option value="{{ $x->id }}" data-nama="{{ $x->name }}"
                    {{ old('nasabah', $data->nasabah_id) == $x->id ? 'selected' : '' }}>
                    {{ $x->id }} - {{ $x->name }}
                </option>
            @endforeach
        </select>
        @error('nasabah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="type">Jenis Simpanan</label>
        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
            <option value="pokok" {{ old('type', $data->type) == 'pokok' ? 'selected' : '' }}>Pokok</option>
            <option value="wajib" {{ old('type', $data->type) == 'wajib' ? 'selected' : '' }}>Wajib</option>
            <option value="sukarela" {{ old('type', $data->type) == 'sukarela' ? 'selected' : '' }}>Sukarela</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="name">Jumlah</label>
        <div class="input-group">
            <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount"
                name="amount" placeholder="Masukan nominal yang akan di Simpan"
                value="{{ old('amount', $data->amount) }}" required data-mask>
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
   
    
    <div class="form-group">
        <label for="name">Keterangan</label>
        <textarea name="desc" id="desc" cols="30" rows="3" class="form-control">{{ old('desc', $data->desc) }}</textarea>
    </div>
</div>
