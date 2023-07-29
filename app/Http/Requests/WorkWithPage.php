<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WorkWithPage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isDev();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'url' => 'string',
            'description' => 'nullable',
            'page_sections.*.name' => 'nullable|string',
            'page_sections.*.page_fields.*.name' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'You must enter a title !',
            'url.required' => 'You need a URL !',
        ];
    }
}
