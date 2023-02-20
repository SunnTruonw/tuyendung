<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateAddShop extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->guard('web')->check()) {
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
        return [
            "name_store" => "required|min:1|max:191",
            "address_store" => "required|min:1|max:191",
            "logo_store" => "mimes:jpeg,jpg,png,svg|nullable",
        ];
    }
    public function messages()
    {
        return [
            "name_store.required" => "Tên gian hàng là trường bắt buộc",
            "name_store.min" => "Tên gian hàng > 1 ký tự",
            "name_store.max" => "Tên gian hàng < 191 ký tự",
            "address_store.required" => "Địa chỉ gian hàng là trường bắt buộc",
            "address_store.min" => "Địa chỉ gian hàng > 1 ký tự",
            "address_store.max" => "Địa chỉ gian hàng < 191 ký tự",
            "logo_store.mimes" => "Logo gian hàng không đúng định dạng",
        ];
    }
}
