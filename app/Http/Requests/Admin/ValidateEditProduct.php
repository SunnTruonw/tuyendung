<?php

namespace App\Http\Requests\Admin;

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
            "masp" => [
                "required",
                "min:3",
                "max:250",
                // Rule::unique("App\Models\Product", 'masp')->where(function ($query) {
                //return $query->where([
                // ['deleted_at', null],
                //]);
                //})
            ],
            // "name_chunha" => "required|min:1|max:191",
            // "phone_chunha" => "required",
            // "attribute_child_id" => "required|array|min:1",
            // "attribute" => "required|array|min:1",
            "type_car" => "required",
            "donvithicong" => "required",
            // "city_id" => "required",
            // "icon" => "mimes:jpeg,jpg,png,svg|nullable",
            // "price" => "nullable",
            "avatar" => "mimes:jpeg,jpg,png,svg|nullable",
            // "category_id" => 'exists:App\Models\CategoryProduct,id',
            "active" => "required",
            // "title_seo" => "nullable|min:1|max:191",
            // "description_seo" => "nullable|min:1|max:191",
            // "keyword_seo" => "nullable|min:1|max:191",
        ];
        $supplier_idOption = request()->input('supplier_idOption') ?? [];
        foreach ($supplier_idOption as $key => $value) {
            $rule['supplier_idOption.' . $key] = 'required|exists:App\Models\Supplier,id';
            $rule['slugOption.' . $key] = 'required';
            $rule['priceOption.' . $key] = 'required|numeric';
        }

        return $rule;
    }
    public function messages()
    {
        return [
            "masp.required" => "S??? khung l?? tr?????ng b???t bu???c",
            "masp.min" => "S??? khung  > 1",
            "masp.max" => "S??? khung  < 191",
            "masp.unique" => "S??? khung  ???? t???n t???i",
            "name_chunha.required" => "H??? t??n l?? tr?????ng b???t bu???c",
            "phone_chunha.required" => "S?? ??i???n tho???i l?? tr?????ng b???t bu???c",
            "name_chunha.min" => "H??? t??n > 1 k?? t???",
            "name_chunha.max" => "H??? t??n < 191 k?? t???",
            "type_car.required" => "D??ng xe l?? tr?????ng b???t bu???c",
            "donvithicong.required" => "????n v??? thi c??ng l?? tr?????ng b???t bu???c",
            "city_id.required" => "B???n ch??a ch???n t???nh/th??nh ph???",
            "attribute.required" => "Vui l??ng ch???n m???t d???ch v??? b???o h??nh",
            "attribute_child_id.required" => "Vui l??ng ch???n m???t d???ch v??? b???o h??nh",
            "price" => "price is required",
            "avatar.mimes" => "avatar  in jpeg,jpg,png,svg",
            "active.required" => "active  is required",
            "category_id.required" => "Vui l??ng ch???n danh m???c",
            "category_id.exists" => "Danh m???c k t???n t???i",
        ];
    }
}
