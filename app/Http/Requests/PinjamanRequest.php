<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nasabah' => 'required|exists:nasabahs,id',
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pinjaman' => 'required|numeric|min:1000000',
            'jangka_waktu' => 'required|integer',
            'catatan' => 'nullable|string', // Catatan bersifat opsional
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nasabah.required' => 'Kolom nasabah wajib diisi.',
            'nasabah.exists' => 'Nasabah dengan ID yang dipilih tidak valid.',
            'tanggal_pengajuan.required' => 'Kolom tanggal pengajuan wajib diisi.',
            'tanggal_pengajuan.date' => 'Kolom tanggal pengajuan harus berupa tanggal yang valid.',
            'jumlah_pinjaman.required' => 'Kolom jumlah pinjaman wajib diisi.',
            'jumlah_pinjaman.numeric' => 'Kolom jumlah pinjaman harus berupa angka.',
            'jumlah_pinjaman.min' => 'Jumlah pinjaman harus setidaknya 1.000.000.',
            'jangka_waktu.required' => 'Kolom jangka waktu wajib diisi.',
            'jangka_waktu.integer' => 'Kolom jangka waktu harus berupa angka.',
            'catatan.string' => 'Kolom catatan harus berupa teks.',
        ];
    }
}
