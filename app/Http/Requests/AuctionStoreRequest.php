<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuctionStoreRequest extends FormRequest
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
        $startDateCarbon = Carbon::now()->startOfMinute();
        $startDate = $startDateCarbon->copy()->addMinutes(5);
        $endDate = Carbon::parse($this->request->get('start_date'))->addMinutes(10);


        return [
            'auction' => 'required|unique:auctions,pigeon_id,'.$this->auction,
            'user_id' => 'required',
            'pigeon_id' => 'required|exists:pigeons,id,user_id,' . $this->user_id,
            'start_date' => 'required|date|before:end_date|after:' . $startDate,
            'end_date' => 'required|date|after:' . $endDate
        ];
    }
    public function prepareForValidation(): void
    {
        $pigeonID = $this->request->get('pigeon_id');
        $this->merge([
            'user_id' => Auth::id(),
            'auction' => $pigeonID
        ]) ;
    }
}
