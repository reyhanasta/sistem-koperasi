<div class="card-body">
    <div class="form-group">
      <label for="name">Nama Nasabah</label>
      <input type="name" class="form-control" id="name" name="name" placeholder="Masukan nama pegawai" value="{{$data->name}}" required>
    </div>
    <div class="form-group">
        <label for="address">Alamat</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Enter customer address" value="{{$data->address}}" required>
    </div>
    <div class="form-group">
        <label for="phone">Nomor Telephone</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="08XX-XXXX-XXXX" value="{{$data->phone}}" required phone-number>
    </div>
    <div class="form-group">
        <label for="date">Tanggal Lahir</label>
        <input type="date" class="form-control" id="date" name="date" value="{{$data->date_of_birth}}" required >
    </div>
    <div class="form-group">
        <label for="gender">Jenis Kelamin</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="male" <?= ($data->gender == "male") ? "checked" : "" ?>>
            <label class="form-check-label">Pria</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="female" <?= ($data->gender == "female") ? "checked" : "" ?>>
            <label class="form-check-label">Wanita</label>
          </div>
    </div>
    {{-- <div class="form-group">
      <label for="exampleInputFile">Foto Nasabah</label>
      <div class="input-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="profile_pict" name="profile_pict">
          <label class="custom-file-label" for="profile_pict">{{$data->profile_pict}}</label>
          
        </div>
      </div>
    </div>
    @if(strlen($data->profile_pict) > 0)
      <img class="profile-user-img img-fluid img-circle" src="{{asset('picture/'.$data->profile_pict)}}" alt="User profile picture">
     @endif --}}
  </div>