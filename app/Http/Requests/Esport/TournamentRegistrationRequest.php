<?php

namespace App\Http\Requests\Esport;

use Illuminate\Foundation\Http\FormRequest;

class TournamentRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tournament = $this->route('tournament');
        $isTeam = ! $tournament || ($tournament->tournament_type ?? null) === 'team' || ! isset($tournament->tournament_type);

        return [
            'team_name' => [$isTeam ? 'required' : 'nullable', 'string', 'max:255'],
            'team_members' => ['nullable', 'array'],
            'team_members.*' => ['string', 'max:255'],
            'in_game_id' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'team_name.required' => 'Nama tim wajib diisi.',
            'in_game_id.required' => 'In-game ID wajib diisi.',
            'team_members.array' => 'Team members harus berupa array.',
            'team_members.*.string' => 'Setiap team member harus berupa string.',
        ];
    }
}
