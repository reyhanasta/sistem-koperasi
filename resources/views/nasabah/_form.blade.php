<div class="card-body">
    <div class="form-group">
        <label for="name">Nama Nasabah</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            placeholder="Masukan nama nasabah" value="{{ old('name', $data->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="ktp">Nomor KTP</label>
        <input type="text" class="form-control @error('ktp') is-invalid @enderror" id="ktp" name="ktp"
            placeholder="Masukkan nomor KTP nasabah" value="{{ old('ktp', $data->ktp) }}" required>
        @error('ktp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Lanjutkan dengan input lainnya -->
    <div class="form-group">
        <label for="exampleInputFile">Foto KTP</label> (Opsional)
        <div class="input-group">
            @if ($data->ktp_image_path)
                <img src="{{ asset('storage/ktp_images/' .$data->ktp_image_path) }}" alt="Gambar KTP" class="img-thumbnail"
                    style="width: 200px; height: auto;">
            @endif
        </div>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input @error('ktp_image_path') is-invalid @enderror"
                    id="ktp_image_path" name="ktp_image_path">
                <label class="custom-file-label"
                    for="ktp_image_path">{{ old('ktp_image_path', $data->ktp_image_path) }}</label>
            </div>
        </div>
        @error('ktp_image_path')
            <div class="text-danger">{{ $message }}</div>
        @enderror

    </div>
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
            placeholder="Enter customer address" required>{{ old('address', $data->address) }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="phone">Nomor Telephone</label>
        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
            placeholder="08XX-XXXX-XXXX" value="{{ old('phone', $data->phone) }}" required phone-number>
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="date">Tanggal Lahir</label>
        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth"
            name="date_of_birth" value="{{ old('date_of_birth', $data->date_of_birth) }}" required>
        @error('date_of_birth')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
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
        @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
