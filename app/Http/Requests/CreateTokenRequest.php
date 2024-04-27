<?php

namespace App\Http\Requests;

use App\Rules\ValidatePassphrase;
use App\Rules\ValidateSecret;
use Illuminate\Foundation\Http\FormRequest;

class CreateTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'passphrase' => [
                'required',
                'string',
                new ValidatePassphrase(),
            ],
            'secret' => [
                'required',
                'string',
                new ValidateSecret(),
            ],
        ];
    }
}