<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return  [
            'title' => 'required|string|max:50|min:2',
            'description' => 'required|string|max:500|min:5',
            'event_date'=>'required',
            'location'=>'required|string|max:500|min:3',
            'total_tickets'=>'required|integer',
        ];
    }
}
