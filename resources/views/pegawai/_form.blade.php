<div class="card-body">
    <div class="form-group">
        <label for="name">Nama Pegawai</label>
        <input type="name" class="form-control" id="name" name="name" placeholder="Masukan nama pegawai"
            value="{{ $dataPegawai->name }}" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            placeholder="Enter email" value="{{ $dataPegawai->email }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="gender">Jenis Kelamin</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="male"
                <?= $dataPegawai->gender == 'male' ? 'checked' : '' ?>>
            <label class="form-check-label">Pria</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="female"
                <?= $dataPegawai->gender == 'female' ? 'checked' : '' ?>>
            <label class="form-check-label">Wanita</label>
        </div>
    </div>
    <div class="form-group">
        <label>Select</label>
        <select class="form-control" name="position">
            <!--NANTI AKAN MENGGUNAKAN DATA MASTER JABATAN-->
            @foreach ($jabatan as $x)
                <option value={{ $x->name }}>{{ $x->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputFile">Foto Pegawai</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="profile_pict" name="profile_pict">
                <label class="custom-file-label" for="profile_pict">{{ $dataPegawai->profile_pict }}</label>

            </div>
        </div>
    </div>
    @if (strlen($dataPegawai->profile_pict) > 0)
        <img class="profile-user-img img-fluid img-circle" src="{{ asset('picture/' . $dataPegawai->profile_pict) }}"
            alt="User profile picture">
    @endif
</div>
