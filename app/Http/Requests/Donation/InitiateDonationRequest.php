<?php

namespace App\Http\Requests\Donation;

use Illuminate\Foundation\Http\FormRequest;

class InitiateDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    public function rules(): array
    {
        return [
            'donor_name'  => ['required', 'string', 'max:255'],
            'donor_email' => ['required', 'email:rfc', 'max:255'],
            'donor_phone' => ['required', 'string', 'max:20'],
            'amount'      => ['required', 'integer', 'min:10000', 'max:100000000'],
            'campaign_id' => ['nullable', 'integer', 'exists:contents,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'donor_name.required'  => 'Nama donatur wajib diisi.',
            'donor_email.required' => 'Alamat email wajib diisi.',
            'donor_email.email'    => 'Alamat email tidak valid.',
            'donor_phone.required' => 'Nomor telepon wajib diisi.',
            'amount.required'      => 'Jumlah donasi wajib diisi.',
            'amount.min'           => 'Donasi minimal Rp 10.000.',
            'amount.max'           => 'Donasi maksimal Rp 100.000.000 per transaksi.',
            'campaign_id.exists'   => 'Kampanye donasi tidak ditemukan.',
        ];
    }
}
