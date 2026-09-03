<?php

namespace App\Http\Requests\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    private bool $spamDetected = false;

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
            $this->spamDetected = true;
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
            'email.email' => 'Alamat email tidak valid.',
        ];
    }

    /**
     * Check if the request was flagged as spam by the honeypot.
     */
    public function isSpam(): bool
    {
        return $this->spamDetected;
    }
}
