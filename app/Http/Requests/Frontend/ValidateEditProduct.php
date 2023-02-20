<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditProduct extends FormRequest
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
        $id=request()->route()->parameter('id');
        return [
            "masp"=>[
                "required",
                "min:1",
                "max:191",
                Rule::unique("App\Models\Product", 'masp')->ignore($id)
            ],
            "name_chunha" => "required|min:1|max:191",
            "phone_chunha"=>'required|max:191',
         //   "email_chunha"=>'required|max:191',
            "address_chunha"=>'required|max:191',
            "type_car"=>'required|max:191',
            "bienkiemsoat"=>[
                "required",
                "min:1",
                "max:191",
                Rule::unique("App\Models\Product", 'bienkiemsoat')->ignore($id)
            ],
            "rollid"=>[
                "nullable",
                "min:1",
                "max:191",
                Rule::unique("App\Models\Product", 'rollid')->ignore($id)
            ],
            "city_id"=>[
                "required",
            ],
            "time_buy"=>'required|date',
            "time_expires"=>'required|date|after:time_buy',
        ];
    }
    public function messages()
    {
        return [
            "masp.required" => "Số khung là trường bắt buộc",
            "masp.min" => "Số khung  > 1",
            "masp.max" => "Số khung  < 191",
            "masp.unique" => "Số khung  đã tồn tại",

            "name_chunha.required" => "Họ tên là trường bắt buộc",
            "name_chunha.max" => "Họ tên  < 191",
            "name_chunha.unique" => "Họ tên  đã tồn tại",

            "phone_chunha.required" => "Số điện thoại là trường bắt buộc",
            "phone_chunha.max" => "Số điện thoại  < 191",

            "address_chunha.required" => "Địa chỉ là trường bắt buộc",
            "address_chunha.max" => "Địa chỉ  < 191",

            "type_car.required" => "Loại xe là trường bắt buộc",
            "type_car.max" => "Loại xe  < 191",

            "bienkiemsoat.required" => "Biển kiểm soát là trường bắt buộc",
            "bienkiemsoat.min" => "Biển kiểm soát  > 1",
            "bienkiemsoat.max" => "Biển kiểm soát  < 191",
            "bienkiemsoat.unique" => "Biển kiểm soát  đã tồn tại",

            "rollid.required" => "rollid là trường bắt buộc",
            "rollid.min" => "rollid  > 1",
            "rollid.max" => "rollid  < 191",
            "rollid.unique" => "rollid  đã tồn tại",

            "time_buy.required" => "Ngày mua là trường bắt buộc",
            "time_buy.date" => "Ngày mua không đúng định dạng",

            "time_expires.required" => "Ngày hết bảo hành là trường bắt buộc",
            "time_expires.date" => "Ngày hết bảo hành không đúng định dạng",
            "time_expires.after" => "Ngày hết bảo hành phải sau ngày mua",

        ];
    }
}
