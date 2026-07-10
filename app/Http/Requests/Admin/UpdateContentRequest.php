<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null; // Requires authentication
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['required', 'string', 'max:255'],
            'body'        => ['nullable', 'string'],
            'tags'        => ['nullable', 'string', 'max:500'],
            'status'      => ['required', 'in:published,draft,archived'],
            'image_url'   => ['nullable', 'string', 'max:500'],
            'image'       => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,gif,pdf,xls,xlsx,doc,docx', 'max:10240'],
            'publish_date'=> ['nullable', 'date'],
            'is_promoted' => ['nullable', 'boolean'],
            'author'      => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Judul konten wajib diisi.',
            'slug.required'   => 'Slug wajib diisi.',
            'status.required' => 'Status konten wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
            'image.mimes'     => 'File yang diunggah harus berupa gambar (JPEG, PNG, WebP, GIF), PDF, atau dokumen Office.',
            'image.max'       => 'Ukuran file maksimal 10 MB.',
        ];
    }
}
