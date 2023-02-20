<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Rules\NumberMin;
use Illuminate\Support\Str;
class ValidateAddAdminUserFrontend extends FormRequest
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

        $validate = [
            'name' => ['required', 'string', 'max:255'],
          //  'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    $validate_value = ['á', 'à', 'ả', 'ạ', 'ã', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'í', 'ì', 'ỉ', 'ĩ', 'ị', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'đ', '`', '~', '!', '#', '|', '$', '%', '^', '&', '*', '(', ')', '+', '=', ',', '.', '/', '?', '>', '<', '\"', '\'', ':', ';', ' '];
                    $contains = Str::contains($value, $validate_value);
                    if ($contains) {
                        $fail($attribute . ' không chứa các ký tự đặc biệt hoặc khoảng trắng!');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            "phone" => ['required', 'regex:/[0-9]{10,11}/', 'unique:users'],
            "address_detail" => 'nullable',
        ];
        return $validate;
    }
    public function messages()
    {
        $messages = [
            "name.required" => "Tên của bạn không được để trống",
            "name.string" => "Tên phải là 1 chuỗi ký tự",
            "name.max" => "Số ký tự phải nhỏ hơn 255",

            "email.required" => "Email không được để trống",
            "email.string" => "Email phải là 1 chuỗi ký tự",
            "email.max" => "Số ký tự phải nhỏ hơn 255",
            "email.email" => "Làm ơn nhập đúng định dạng",
            "email.unique" => "Email đã tồn tại",

            "username.required" => "Tên đăng nhập của bạn không được để trống",
            "username.string" => "Tên đăng nhập phải là 1 chuỗi ký tự",
            "username.max" => "Số ký tự phải nhỏ hơn 255",
            "username.unique" => "Tên đăng nhập đã tồn tại",

            "password.required" => "Mật khẩu của bạn không được để trống",
            "password.string" => "Mật khẩu phải là 1 chuỗi ký tự",
            "password.min" => "Số ký tự phải lớn hơn 8",
            "password.confirmed" => "Mật khẩu và nhập lại mật khẩu không trùng khớp",

            "sex.required" => "Bạn chưa chọn giới tính",

            "phone.required" => "Số điện thoại của bạn không được để trống",
            "phone.regex" => "Số điện thoại là number và có 10 đến 11 ký tự",
            "phone.unique" => "Số điện thoại đã được đăng ký",
        ];
        return $messages;

    }
}
