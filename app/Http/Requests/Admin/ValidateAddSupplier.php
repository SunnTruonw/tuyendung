<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAddSupplier extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->guard('admin')->check()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rule = [
            "name" =>  "required|min:3|max:191",
            "order" => "nullable|numeric",
            "email" => "string|email|max:191|nullable",
            "phone" => "nullable|max:191",
            "fax" => "nullable|max:191",
            "website" => "nullable|max:191",
            // "description"=>"required",
            "logo_path" => "mimes:jpeg,jpg,png,svg|nullable|file|max:3000",
            "active" => "required",
        ];

      //  dd($rule);
        return $rule;
    }
    public function messages()
    {
        return [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 191",
            "slug.required" => "slug slider is required",
            "image_path.mimes" => "image  in jpeg,jpg,png,svg",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot slider is accepted",
        ];
    }
}
