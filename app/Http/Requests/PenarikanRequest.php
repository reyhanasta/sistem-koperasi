<?php

namespace App\Http\Requests;

use App\Models\BukuTabungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PenarikanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nasabah' => 'required', // Ubah 'Nasabah' menjadi 'nasabah'
            'amount' => [
                'required',
                'min:20000',
                'numeric',
                function ($attribute, $value, $fail) {
                    // Mengambil data rekening nasabah menggunakan model Eloquent
                    // $rekeningNasabah = BukuTabungan::where('nasabah_id', $this->input('nasabah'))->first();
                    

                    $balance = $this->input('balance');
                    if (!$balance || $balance == 0 ) {
                        $fail("Invalid Nasabah ID");
                        return;
                    }
                    if ($value > $balance) {
                        $fail("Jumlah penarikan melebihi saldo.");
                    }
                },
            ],
        ];
    }
}
