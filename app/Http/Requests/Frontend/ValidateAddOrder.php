<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAddOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->guard('web')->check()){
            return true;
        }else{
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
            "name"=>"required|min:1|max:191",
            'email' => ['required', 'string', 'email', 'max:191'],
            "phone" => ['required', 'regex:/[0-9]{10,11}/'],
            "city_id"=>'exists:App\Models\City,id|required',
            "district_id"=>'exists:App\Models\District,id|required',
            "commune_id"=>'exists:App\Models\Commune,id|required',
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"Họ tên là trường bắt buộc",
            "name.min"=>"Họ tên > 1",
            "name.max"=>"Họ tên < 191",
            "email.required"=>"Email là trường bắt buộc",
            "email.string"=>"Email  là 1 chuỗi",
            "email.email"=>"Email không đúng định dạng",
            "email.max"=>"Email < 191",
            "city_id.required"=>"Thành phố là trường bắt buộc",
            "district_id.required"=>"Quận huyện là trường bắt buộc",
            "commune_id.required"=>"Phường xã là trường bắt buộc",
        ];
    }
}
