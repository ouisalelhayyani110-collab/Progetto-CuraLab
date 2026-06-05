<?php

namespace App\Http\Requests;

use App\Models\Paziente;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome'    => ['required', 'string', 'max:100'],
            'cognome' => ['required', 'string', 'max:100'],
            'email'   => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                // Unique sulla tabella pazienti, escludendo il paziente corrente
                Rule::unique(Paziente::class)->ignore($this->user()->id),
            ],
        ];
    }
}