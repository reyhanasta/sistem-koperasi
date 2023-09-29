<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NasabahRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ubah sesuai dengan aturan akses yang Anda butuhkan
    }

    public function rules()
    {
        $nasabahId = $this->route('nasabah'); // Mendapatkan ID Nasabah yang sedang diedit
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/u', // Hanya huruf, spasi, dan karakter lain yang diizinkan

            ],
            'gender' => [
                'required',
                'in:male,female',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s.,-]*$/u', // Hanya huruf, angka, spasi, tanda koma, dan tanda minus yang diizinkan
            ],
            'ktp' => [
                'required',
                'string',
                'max:16',
                'regex:/^\d{16}$/u', // Sesuaikan panjang maksimal KTP, 16 digit angka
                $nasabahId
                    ? Rule::unique('nasabahs', 'ktp')->ignore($nasabahId)
                    : Rule::unique('nasabahs', 'ktp')
            ],
            'date_of_birth' => [
                'required',
                'date',
                'date_format:Y-m-d'
            ],
            'ktp_image_path' => [
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:10240' // Maksimum 10MB
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama nasabah harus diisi.',
            'name.string' => 'Nama nasabah harus berupa teks.',
            'name.max' => 'Nama nasabah tidak boleh lebih dari :max karakter.',
            'name.regex' => 'Nama tidak boleh memiliki unsur simbol.',


            'gender.required' => 'Jenis kelamin harus dipilih.',
            'gender.in' => 'Jenis kelamin yang dipilih tidak valid.',

            'phone.required' => 'Nomor telepon harus diisi.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',

            'address.required' => 'Alamat harus diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari :max karakter.',
            'address.regex' => 'Format Alamat tidak valid.',

            'ktp.required' => 'Nomor KTP harus diisi.',
            'ktp.string' => 'Nomor KTP harus berupa teks.',
            'ktp.unique' => 'Nomor KTP sudah pernah terdaftar sebelumnya.',
            'ktp.regex' => 'Nomor KTP memiliki format yang tidak sesuai.',
            'ktp.max' => 'Nomor KTP tidak boleh lebih dari 16 karakter.',

            'date_of_birth.required' => 'Tanggal lahir harus diisi.',
            'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'date_of_birth.date_format' => 'Format Tanggal tidak valid.',

            'ktp_image_path.image' => 'File yang diunggah harus berupa gambar.',
            'ktp_image_path.mimes' => 'File gambar harus dalam format jpeg, png, jpg, atau gif.',
            'ktp_image_path.max' => 'File gambar tidak boleh lebih dari :max Kb.', // Ubah pesan ini sesuai kebutuhan

            // Sisipkan pesan kesalahan untuk aturan validasi lainnya seperti yang Anda butuhkan.
        ];
    }
}
