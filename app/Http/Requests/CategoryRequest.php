<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_product' => 'sometimes|boolean',
            'documentations.*.name' => 'required|string|max:255',
            'documentations.*.type' => 'required|string|in:text,html,numeric,date,date_time,gallery,image,carousel,price,audio,link,list',
            'documentations.*.prefix' => 'string|max:255|nullable',
            'documentations.*.suffix' => 'string|max:255|nullable',
            'documentations.*.currency' => 'string|max:255|nullable',
            'documentations.*.user_id' => 'integer',
            'documentations.*.doc_options.*.option' => 'required|string|max:255',
        ];
/*         $input = array(
            'name' => ''
         );
        $v = Validator::make($input, $rules);

        if ($v->fails()) {
            dd(session()->get('errors'));
          } */
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_product' => 'sometimes|boolean',
            'documentations.*.name' => 'required|string|max:255',
            'documentations.*.type' => 'required|string|in:text,html,numeric,date,date_time,gallery,image,carousel,price,audio,link,list',
            'documentations.*.prefix' => 'string|max:255|nullable',
            'documentations.*.suffix' => 'string|max:255|nullable',
            'documentations.*.currency' => 'string|max:255|nullable',
            'documentations.*.user_id' => 'integer',
            'documentations.*.doc_options.*.option' => 'required|string|max:255',
        ];
    }
}
