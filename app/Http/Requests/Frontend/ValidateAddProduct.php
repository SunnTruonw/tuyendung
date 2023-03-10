<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateAddProduct extends FormRequest
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
            "masp"=>[
                "required",
                "min:1",
                "max:191",
                Rule::unique("App\Models\Product", 'masp')
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
                Rule::unique("App\Models\Product", 'bienkiemsoat')
            ],
            "city_id"=>[
                "required",
            ],
            "rollid"=>[
                "nullable",
                "min:1",
                "max:191",
                Rule::unique("App\Models\Product", 'rollid')
            ],
            "time_buy"=>'required|date',
            "time_expires"=>'required|date|after:time_buy',
            // "avatar" => "mimes:jpeg,jpg,png,svg|nullable",
            // "category_id" => 'exists:App\Models\CategoryProduct,id',
            // "active" => "required",

            // "city_id"=> ['nullable','required_with:district_id', 'exists:App\Models\City,id'],
            //  "district_id"=>'nullable|required_with:commune_id|exists:App\Models\District,id',
            //  "commune_id"=>'required|exists:App\Models\Commune,id',
            //   "address_detail"=>'required|max:191',


            "title_seo"=>"nullable|min:1|max:191",
            "description_seo"=>"nullable|min:1|max:191",
            "keyword_seo"=>"nullable|min:1|max:191",
        ];
    }
    public function messages()
    {
        return [
            "masp.required" => "S??? khung l?? tr?????ng b???t bu???c",
            "masp.min" => "S??? khung  > 1",
            "masp.max" => "S??? khung  < 191",
            "masp.unique" => "S??? khung  ???? t???n t???i",

            "name_chunha.required" => "H??? t??n l?? tr?????ng b???t bu???c",
            "name_chunha.max" => "H??? t??n  < 191",
            "name_chunha.unique" => "H??? t??n  ???? t???n t???i",

            "phone_chunha.required" => "S??? ??i???n tho???i l?? tr?????ng b???t bu???c",
            "phone_chunha.max" => "S??? ??i???n tho???i  < 191",

            "address_chunha.required" => "?????a ch??? l?? tr?????ng b???t bu???c",
            "address_chunha.max" => "?????a ch???  < 191",

            "type_car.required" => "Lo???i xe l?? tr?????ng b???t bu???c",
            "type_car.max" => "Lo???i xe  < 191",

            "bienkiemsoat.required" => "Bi???n ki???m so??t l?? tr?????ng b???t bu???c",
            "bienkiemsoat.min" => "Bi???n ki???m so??t  > 1",
            "bienkiemsoat.max" => "Bi???n ki???m so??t  < 191",
            "bienkiemsoat.unique" => "Bi???n ki???m so??t  ???? t???n t???i",

            "rollid.required" => "rollid l?? tr?????ng b???t bu???c",
            "rollid.min" => "rollid  > 1",
            "rollid.max" => "rollid  < 191",
            "rollid.unique" => "rollid  ???? t???n t???i",

            "time_buy.required" => "Ng??y mua l?? tr?????ng b???t bu???c",
            "time_buy.date" => "Ng??y mua kh??ng ????ng ?????nh d???ng",

            "time_expires.required" => "Ng??y h???t b???o h??nh l?? tr?????ng b???t bu???c",
            "time_expires.date" => "Ng??y h???t b???o h??nh kh??ng ????ng ?????nh d???ng",
            "time_expires.after" => "Ng??y h???t b???o h??nh ph???i sau ng??y mua",


        ];
    }
}
