<?php

namespace App\Http\Requests;

use App\Helper;
use App\Models\News;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NewsStoreRequest extends FormRequest
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
            'title' => 'required|max:255',
            'content' => 'required|max:1500',
            'slug' => 'required'
        ];
    }

    protected function prepareForValidation()
    {

        if ($this->request->has('title')) {
            $this->merge([
                'slug' => Helper::findSlug(News::class, $this->request->get('title'))
            ]);
        }

    }
}
