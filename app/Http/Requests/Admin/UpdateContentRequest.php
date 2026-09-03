<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UpdateContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->canManageContent();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'max:5000000'],
            'tags' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:published,draft,archived'],
            'image_url' => [
                'nullable',
                'string',
                'max:500',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if (! is_string($value) || trim($value) === '') {
                        return;
                    }
                    $val = trim($value);
                    if (preg_match('/^(javascript|vbscript|data):/i', $val)) {
                        $fail('URL gambar/berkas tidak valid atau menggunakan protokol yang dilarang.');

                        return;
                    }
                    $isUrl = filter_var($val, FILTER_VALIDATE_URL) && preg_match('/^https?:\/\//i', $val);
                    $isSafeRelative = preg_match('/^(\/|storage\/|uploads\/|assets\/)/i', $val);
                    if (! $isUrl && ! $isSafeRelative) {
                        $fail('URL gambar/berkas harus berupa tautan web yang valid (http/https) atau jalur berkas lokal yang aman.');
                    }
                },
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,webp,gif,pdf,xls,xlsx,doc,docx',
                'max:2048',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if ($value instanceof UploadedFile) {
                        $ext = strtolower($value->getClientOriginalExtension());
                        $dangerousExts = ['php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'phps', 'cgi', 'pl', 'py', 'sh', 'bat', 'exe', 'svg', 'htaccess'];
                        if (in_array($ext, $dangerousExts)) {
                            $fail('Ekstensi file yang diunggah tidak diizinkan demi alasan keamanan.');

                            return;
                        }

                        $mime = $value->getMimeType();
                        $allowedMimes = [
                            'image/jpeg', 'image/png', 'image/webp', 'image/gif',
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ];
                        if (! in_array($mime, $allowedMimes)) {
                            $fail('File yang diunggah memiliki tipe MIME asli yang tidak valid.');
                        }
                    }
                },
            ],
            'publish_date' => ['nullable', 'date'],
            'is_promoted' => ['nullable', 'boolean'],
            'author' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul konten wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'status.required' => 'Status konten wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'image.mimes' => 'File yang diunggah harus berupa gambar (JPEG, PNG, WebP, GIF), PDF, atau dokumen Office.',
            'image.max' => 'Ukuran file maksimal 2 MB agar server tetap cepat dan hemat penyimpanan.',
        ];
    }
}
