<?php

namespace App\Http\Requests;

use App\Rules\PigeonColor;
use App\Rules\PigeonSize;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PigeonStoreRequest extends FormRequest
{
    use HasUser;

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
            'user_id' => 'required',
            'code' => 'required|unique:pigeons,code',
            'mother_name' => 'required|max:255',
            'father_name' => 'required|max:255',
            'color' => ['required', new PigeonColor()],
            'size' => ['required', new PigeonSize()],
            'rating' => 'required|integer|between:1,5',
            'sex' => 'required|bool',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpg,png',
            'family_tree_image' => 'required|image|mimes:jpg,png'
        ];
    }

}
