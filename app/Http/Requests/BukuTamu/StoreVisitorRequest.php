<?php

namespace App\Http\Requests\BukuTamu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVisitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Public endpoint - no authorization required
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'address' => ['nullable', 'string', 'max:500'],
            'purpose' => ['required', Rule::in(array_keys(config('buku_tamu.purpose_options')))],
            'purpose_other' => ['required_if:purpose,other', 'nullable', 'string', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'visit_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'photo' => ['required', 'string', 'max:5242880'], // 5MB base64
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'phone' => 'nomor telepon',
            'address' => 'alamat',
            'purpose' => 'tujuan kunjungan',
            'purpose_other' => 'tujuan lainnya',
            'institution' => 'instansi',
            'position' => 'jabatan',
            'visit_date' => 'tanggal kunjungan',
            'notes' => 'catatan',
            'photo' => 'foto',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'purpose.required' => 'Tujuan kunjungan wajib dipilih.',
            'purpose.in' => 'Tujuan kunjungan tidak valid.',
            'purpose_other.required_if' => 'Tujuan lainnya wajib diisi.',
            'photo.required' => 'Foto wajib diupload.',
            'photo.max' => 'Ukuran foto maksimal 5MB.',
            'latitude.required' => 'Data lokasi wajib diisi.',
            'longitude.required' => 'Data lokasi wajib diisi.',
            'latitude.between' => 'Data latitude tidak valid.',
            'longitude.between' => 'Data longitude tidak valid.',
        ];
    }
}
