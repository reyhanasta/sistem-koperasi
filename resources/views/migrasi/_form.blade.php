<div class="card-body">
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input @error('sql_file') is-invalid @enderror" id="sql_file"
                name="sql_file" value="{{ old('sql_file', $data->sql_file ?? '') }}" accept=".sql" required>
            <label class="custom-file-label" for="sql_file">{{ old('sql_file', $data->sql_file ?? 'Pilih file
                migrasi')
                }}

            </label>
        </div>
    </div>
</div>