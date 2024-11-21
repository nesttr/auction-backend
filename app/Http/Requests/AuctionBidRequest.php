<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuctionBidRequest extends FormRequest
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
            'auction' => 'required|exists:auctions,uuid',
            "bid" => 'required|numeric|min:1|max:1000000',
            'user_id' => 'required',
        ];
    }
    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
            'auction' => $this->route('uuid')
        ]) ;
    }
}
