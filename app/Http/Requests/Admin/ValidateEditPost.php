<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->guard('admin')->check()){
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
            "slug"=>[
                "required",
                "min:1",
                "max:191",
                Rule::unique("App\Models\Post", 'slug')->where(function ($query) {
                    $id=request()->route()->parameter('id');
                    return $query->where([
                        ['deleted_at', null],
                        ['id','<>',$id],
                    ]);
                })
            ],
           // "view"=>"nullable|integer",
            "hot"=>"nullable|integer",
            "avatar"=>"mimes:jpeg,jpg,png,svg|nullable",
            "category_id"=>'exists:App\Models\CategoryPost,id',
            "active"=>"required",
            "title_seo"=>"nullable|min:1|max:191",
            "description_seo"=>"nullable|min:1|max:191",
            "keyword_seo"=>"nullable|min:1|max:191",
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"Name post is required",
            "name.min"=>"Name post > 1",
            "name.max"=>"Name post < 191",
            "slug.required"=>"slug post is required",
            "slug.unique"=>"slug post is exits",
            "hot.integer"=>"hot is integer",
            "view.integer"=>"view is integer",
            "avatar.mimes"=>"avatar  in jpeg,jpg,png,svg",
            "active.required"=>"active  is required",
            "category_id"=>"category_id k tồn tại",
            "checkrobot.accepted"=>"checkrobot product is accepted",
        ];
    }
}
