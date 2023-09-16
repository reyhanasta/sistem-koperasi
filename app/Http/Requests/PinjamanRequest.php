<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            
                // Atur aturan validasi sesuai kebutuhan
                'nasabah' => 'required',
                'tanggal_pengajuan' => 'required|date',
                'jumlah_pinjaman' => 'required|numeric|min:1000000',
                'jenis_pinjaman' => 'required',
                'tujuan_pinjaman' => 'required',
                'jangka_waktu' => 'required|integer',
                'bunga' => 'required|numeric',
                'catatan' => 'nullable', // Catatan bersifat opsional
            
        ];
    }
}
