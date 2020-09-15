<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackagesTypesRequest extends FormRequest
{
    /**
     * Determine if the event is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'length' => 'required',
            'booking_min' => 'required',
            'booking_max' => 'required',
            'player_min' => 'required',
            'player_max' => 'required',
            'guest_min' => 'required',
            'guest_max' => 'required',
            'package_id' => 'required',
            'status' => 'required',
            'alias' => 'required',
        ];
    }
}