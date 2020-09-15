<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestsRequest extends FormRequest
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
            'doc_id' => 'required|unique:guests',
            'first_name' => 'required',
			'last_name' => 'required',
            'is_active' => 'required',
        ];
    }
}