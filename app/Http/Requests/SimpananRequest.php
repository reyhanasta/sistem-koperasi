<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpananRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nasabah' => 'required',
            'kode' => 'required|unique:simpanans,kode_simpanan',
            'type' => 'required',
            'amount' => 'required|numeric|min:5000',
            'desc' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'kode.unique' => 'Kode Simpanan sudah digunakan.',
            'amount.min' => 'Jumlah simpanan harus lebih dari :min.',
        ];
    }
}
