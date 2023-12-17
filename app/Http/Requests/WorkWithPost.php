<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WorkWithPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isDev() || Auth::user()->isAdmin() || Auth::user()->isEditor();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'body' => 'nullable|string',
            'slug' => 'required|string',
            'excerpt' => 'nullable',
            'doc_values.*.value_date' => 'nullable|date',
            'doc_values.*.value_date_time' => 'nullable|date',
            'doc_values.*.value_html' => 'nullable|starts_with:<',
            'doc_values.*.value_price' => 'nullable|numeric',
            'doc_values.*.value_number' => 'nullable|numeric',
            'doc_values.*.value_text' => 'nullable|string',
            'doc_values.*.value_gallery' => 'nullable|boolean',
            'doc_values.*.value_image' => 'nullable|boolean',
            'doc_values.*.value_carousel' => 'nullable|boolean',
            'doc_values.*.value_audio' => 'nullable|boolean',
            'doc_values.*.value_list' => 'nullable',
            'doc_values.*.value_link' => 'nullable|url',
            'doc_values.*.images.*' => 'sometimes|image|max:2048',
            'doc_values.*.audio.*' => 'sometimes|file|max:2048',
            'doc_values.*.gallery.*' => 'sometimes|image|max:2048',
            'doc_values.*.carousel.*' => 'sometimes|image|max:2048',
            'doc_values.*.documentation_id' => 'required|integer',
        ];
    }
}
