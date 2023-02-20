<?php

namespace App\Http\Requests\Admin;

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
            "icon" => "mimes:jpeg,jpg,png,svg|nullable",
            "price" => "nullable",
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
            "masp.required" => "Số khung là trường bắt buộc",
            "masp.min" => "Số khung  > 1",
            "masp.max" => "Số khung  < 191",
            "masp.unique" => "Số khung  đã tồn tại",
            "name_chunha.required" => "Họ tên là trường bắt buộc",
            "phone_chunha.required" => "Sô điện thoại là trường bắt buộc",
            "name_chunha.min" => "Họ tên > 1 ký tự",
            "name_chunha.max" => "Họ tên < 191 ký tự",
            "type_car.required" => "Dòng xe là trường bắt buộc",
            "donvithicong.required" => "Đơn vị thi công là trường bắt buộc",
            "city_id.required" => "Bạn chưa chọn tỉnh/thành phố",
            "attribute.required" => "Vui lòng chọn một dịch vụ bảo hành",
            "attribute_child_id.required" => "Vui lòng chọn một dịch vụ bảo hành",
            "price" => "price is required",
            "avatar.mimes" => "avatar  in jpeg,jpg,png,svg",
            "active.required" => "active  is required",
            // "category_id.required" => "Vui lòng chọn danh mục",
            "category_id.exists" => "Danh mục k tồn tại",
        ];
    }
}
