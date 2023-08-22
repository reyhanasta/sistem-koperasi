<div class="card-body">
    <div class="form-group ">
        <label>Data Nasabah</label>
        @if ($customer->count() > 0)
            <select class="form-control" name="customer">
                <!--NANTI AKAN MENGGUNAKAN DATA MASTER JABATAN-->
                @foreach ($customer as $x)
                    <option value={{ $x->id }}>{{ $x->id }} - {{ $x->name }}</option>
                @endforeach
            </select>
        @else
            <a class="form-control btn btn-success" href="{{ url('customer/create/') }}" class="btn btn-primary"><i
                    class="fas fa-plus"></i><span> Tambah Data Nasabah</span></a>
        @endif

    </div>
    <div class="form-group">
        <label for="name">Jumlah</label>
        <div class="input-group">
            <input type="text" class="form-control  @if ($errors->has('amount')) is-invalid @endif" id="amount" name="amount"
                placeholder="Masukan nominal yang akan di Simpan" value="{{ $data->amount }}" required data-mask>
        </div>
        @if ($errors->has('amount'))
            <div class="text-danger">{{ $errors->first('amount') }}</div>
        @endif
    </div>


    <div class="form-group">
        <label for="name">Keterangan</label>
        <textarea name="desc" id="desc" cols="30" rows="3" class="form-control"></textarea>
    </div>
</div>
