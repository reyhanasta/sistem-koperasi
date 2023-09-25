<div class="card-body">
    <div class="form-group">
        <label for="name">Nama Nasabah</label>
        <input type="name" class="form-control" id="name" name="name" placeholder="Masukan nama pegawai"
            value="{{ $data->name }}" required>
        @error('ktp')
            <div class="text-danger">KTP yang sama sudah di inputkan</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="name">Nomor KTP</label>
        <input type="ktp" class="form-control" id="ktp" name="ktp" placeholder="Masukan KTP Nasabah"
            value="{{ $data->ktp }}" required>
        @error('ktp')
            <div class="text-danger">KTP yang sama sudah di inputkan</div>
        @enderror
    </div>


    <div class="form-group">
        <label for="exampleInputFile">Foto KTP</label> (Opsional)
        <div class="input-group">
            @if ($data->ktp_image_path)
                <img src="{{ asset('storage/' . $data->ktp_image_path) }}" alt="Gambar KTP" class="img-thumbnail"
                    style="width: 200px; height: auto;">
            @endif
        </div>

        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="ktp_image" name="ktp_image">
                <label class="custom-file-label" for="ktp_image">{{ $data->ktp_image_path }}</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="address">Alamat</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Enter customer address"
            value="{{ $data->address }}" required>
    </div>
    <div class="form-group">
        <label for="phone">Nomor Telephone</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="08XX-XXXX-XXXX"
            value="{{ $data->phone }}" required phone-number>
    </div>
    <div class="form-group">
        <label for="date">Tanggal Lahir</label>
        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
            value="{{ $data->date_of_birth }}" required>
    </div>
    <div class="form-group">
        <label for="gender">Jenis Kelamin</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="male"
                {{ old('gender', $data->gender) === 'male' ? 'checked' : '' }}>
            <label class="form-check-label">Pria</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="female"
                {{ old('gender', $data->gender) === 'female' ? 'checked' : '' }}>
            <label class="form-check-label">Wanita</label>
        </div>
    </div>

</div>
