<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAddReview extends FormRequest
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
            "name" => "required|min:1|max:191",
            "slug" => [
                "required",
                "min:1",
                "max:191",
                // Rule::unique("App\Models\Product", 'slug')->where(function ($query) {
                //     return $query->where([
                //         ['deleted_at', null],
                //     ]);
                // })
            ],
            "link" => [
                "nullable",
                "min:1",
                "max:191",
            ],
            "avatar" => "mimes:jpeg,jpg,png,svg|nullable",
            "title_seo"=>"nullable|min:1|max:191",
            "description_seo"=>"nullable|min:1|max:191",
            "keyword_seo"=>"nullable|min:1|max:191",
        ];
    }
}
