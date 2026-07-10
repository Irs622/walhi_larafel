<?php

namespace App\Http\Requests\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    /**
     * Move honeypot detection into the request lifecycle.
     * If the hidden `extra_name` field is filled, we flag it so the controller
     * can silently ignore without revealing to bots that they were caught.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('extra_name')) {
            // Mark as spam — controller checks this flag
            $this->merge(['_is_spam' => true]);
        }
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Alamat email tidak valid.',
        ];
    }

    /**
     * Check if the request was flagged as spam by the honeypot.
     */
    public function isSpam(): bool
    {
        return (bool) $this->input('_is_spam', false);
    }
}
