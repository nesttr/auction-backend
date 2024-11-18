<?php

namespace App\Http\Requests;

use App\Rules\IdentityNumber;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\Rules\Phone;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'identity_number' => ['required', 'unique:users', new IdentityNumber()],
            'full_name' => ['required', 'string'],
            'password' => ['required', 'min:8','max:16'],
            'email' => ['required', 'email', 'unique:users','email:rfc,dns'],
            'phone_number'    => ['required','unique:users',(new Phone)->country(['TR'])->type('mobile')]
        ];
    }
}
