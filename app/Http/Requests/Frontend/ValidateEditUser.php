<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ArrayValueExistDatabase;
use App\Models\Role;

class ValidateEditUser extends FormRequest
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
        $id = auth()->user()->id;
        $rules = [];
        //  if (!auth()->user()->provider) {
        $rules = [
            "name" => "required|min:1|max:191",
            "email" =>  [
                "required",
                Rule::unique("App\Models\User", 'email')->where(function ($query) use ($id) {
                    return $query->where([
                        ['deleted_at', '=', null],
                        ['id', '<>', $id],
                    ]);
                })
            ],
            "username" =>  [
                "required",
                Rule::unique("App\Models\User", 'username')->where(function ($query) use ($id) {
                    return $query->where([
                        ['deleted_at', '=', null],
                        ['id', '<>', $id],
                    ]);
                })
            ],
            "avatar_path" => "mimes:jpeg,jpg,png,svg|nullable",
            "password" => "min:6|nullable",
            "password_confirmation" => "same:password",

            "phone" =>  [
                'required',
                'regex:/[0-9]{10,11}/',
                Rule::unique("App\Models\User", 'phone')->where(function ($query) use ($id) {
                    return $query->where([
                        ['deleted_at', '=', null],
                        ['id', '<>', $id],
                    ]);
                })
            ],

            //  'date_birth' => "nullable|date:'d-m-Y'",

            //  "city_id"=> ['required', 'exists:App\Models\City,id'],
            //  "district_id"=>'required|exists:App\Models\District,id',
            //  "commune_id"=>'required|exists:App\Models\Commune,id',

            //  "address_detail" => "nullable",

            // "sex" => "required",
            //  "active" => "required",
        ];
        //  }
        // $rules['date_birth'] = ['required', 'date','before:today'];
        // $rules['info_more'] = ['required', 'string', 'max:191'];
        // $rules['you_become'] = ['required', 'string', 'max:191'];
        // if(auth()->user()->type==1){
        //     $rules['city_id']=['required', 'exists:App\Models\City,id'];
        //     $rules['district_id']='required|exists:App\Models\District,id';
        // }

        return $rules;
    }
    public function messages()
    {
        return [
            "avatar_path.mimes" => "???nh ?????i di???n kh??ng ????ng ?????nh d???ng (jpeg,jpg,png,svg)",
            "name.required" => "H??? t??n l?? tr?????ng b???t bu???c",
            "name.min" => "H??? t??n ph???i c?? ????? d??i 3",
            "name.max" => "H??? t??n ph???i c?? ????? d??i 250",
            "email.required" => "email l?? tr?????ng b???t bu???c",
            "email.unique" => "email ???? t???n t???i",
            "username.required" => "username l?? tr?????ng b???t bu???c",
            "username.unique" => "username ???? t???n t???i",
            "cmt.required" => "CMT l?? tr?????ng b???t bu???c",
            "cmt.unique" => "CMT ???? t???n t???i",
            "ctk.required" => "ctk l?? tr?????ng b???t bu???c",
            "ctk.min" => "CTK ph???i c?? ????? d??i 3",
            "ctk.max" => "CTK ph???i c?? ????? d??i 250",

            "stk.required" => "STK l?? tr?????ng b???t bu???c",
            "stk.min" => "STK ph???i c?? ????? d??i 3",
            "stk.max" => "STK ph???i c?? ????? d??i 250",

            "password.min" => "password ph???i l???n h??n 6 k?? t???",
            "password_confirmation.same" => "Password nh???p kh??ng gi???ng nhau",
            "phone.required" => "S??? ??i???n tho???i l?? tr?????ng b???t bu???c",
            "phone.min" => "S??? ??i???n tho???i  kh??ng ????ng ?????nh d???ng",
            "phone.max" => "S??? ??i???n tho???i  kh??ng ????ng ?????nh d???ng",

            "date_birth.date" => "Ng??y sinh  kh??ng ????ng ?????nh d???ng",
            "address.required" => "?????a ch??? l?? tr?????ng b???t bu???c",


            "bank_id.exists" => "Ng??n h??ng l?? kh??ng h???p l???",
            "bank_id.required" => "Ng??n h??ng l?? tr?????ng b???t bu???c",
            "bank_branch.required" => "Chi nh??nh ng??n h??ng l?? tr?????ng b???t bu???c",
            "bank_branch.min" => "CNNH ph???i c?? ????? d??i 3",
            "bank_branch.max" => "CNNH ph???i c?? ????? d??i 250",

            "active.required" => "Active l?? tr?????ng b???t bu???c",
            "checkrobot.accepted" => "Checkrobot  is accepted",
        ];
    }
}
