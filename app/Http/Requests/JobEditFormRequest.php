<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobEditFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5',
            "feature_image" => 'mimes:png,jpeg,jpg|max:2048',
            "description" => 'required|min:10',
            "roles" => 'required|min:10',
            "job_type" => 'required',
            "address" => 'required',
            "salary" => 'required',
            "date" => 'required',
        ];
    }
}