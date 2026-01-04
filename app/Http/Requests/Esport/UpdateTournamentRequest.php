<?php

namespace App\Http\Requests\Esport;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTournamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization handled by middleware/policies
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
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'game' => ['sometimes', 'required', Rule::in(array_keys(config('esport.games')))],
            'date' => ['sometimes', 'required', 'date'],
            'time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:500'],
            'prize_pool' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'max_participants' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'registration_deadline' => ['nullable', 'date'],
            'rules' => ['nullable', 'string', 'max:10000'],
            'contact_info' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'string', 'max:5242880'], // 5MB base64
            'status' => ['sometimes', 'required', Rule::in(array_keys(config('esport.tournament_statuses')))],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul turnamen',
            'description' => 'deskripsi',
            'game' => 'game',
            'date' => 'tanggal',
            'time' => 'waktu',
            'location' => 'lokasi',
            'prize_pool' => 'hadiah',
            'max_participants' => 'maksimal peserta',
            'registration_deadline' => 'batas pendaftaran',
            'rules' => 'peraturan',
            'contact_info' => 'kontak',
            'image' => 'gambar',
            'status' => 'status',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul turnamen wajib diisi.',
            'game.required' => 'Game wajib dipilih.',
            'game.in' => 'Game tidak valid.',
            'date.required' => 'Tanggal turnamen wajib diisi.',
            'prize_pool.numeric' => 'Hadiah harus berupa angka.',
            'max_participants.integer' => 'Maksimal peserta harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
