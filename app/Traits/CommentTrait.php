<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
/**
 *
 */
trait CommentTrait
{
    /*
     store image upload and return null || array
     @param
     $request type Request, data input
     $fieldName type string, name of field input file
     $folderName type string; name of folder store
     return array
     [
         "file_name","file_path"
     ]
    */

    public function storeComment($modelInstance,$slug,$id,$request)
    {
        $commentOf = $modelInstance->where([
            ['id',$id],
            ['slug',$slug],
            ['active',1],
        ])
        ->first();
        if(!$commentOf){
            abort(404);
        }
        if (!Auth::check()) {
            if ($request->has('social') && $request->input('social')) {
                session()->put('urlBack', $request->fullUrl());
                return redirect($request->input('social'));
            }
        }
        if ($request->content) {
            if ($request->ajax()) {
                $rule = [];
                if (!Auth::check()) {
                    $dataCommentCreate['email'] = $request->email;
                    $dataCommentCreate['name'] = $request->name;
                    $rule = [
                        // 'g-recaptcha-response' => 'required|recaptcha',
                        'email' => 'required|email|string|max:191',
                        'name' => 'required|string|max:191',
                    ];
                    $validator = Validator::make($request->all(), $rule);
                    // dd($validator->errors()->all());
                    if (!$validator->passes()) {
                        return response()->json([
                            'code' => 200,
                            'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                                "errors" => $validator->errors()
                            ])->render(),
                            'messange' => 'success',
                            'validate' => true
                        ], 200);
                    }
                }

                try {
                    DB::beginTransaction();
                    $dataCommentCreate = [
                        "content" => $request->input('content'),
                        "parent_id" => $request->input('parent_id') ?? 0,
                        'user_id' =>  0,
                        'active'=>0
                    ];
                    if ($request->has('image_path') && $request->image_path) {
                        $dataUploadImage = $this->storageTraitUpload($request, "image_path", "comment");
                        if (!empty($dataUploadImage)) {
                            $dataCommentCreate["image_path"] = $dataUploadImage["file_path"];
                        }
                    }
                    if (Auth::check()) {
                        $user = auth()->user();
                        $dataCommentCreate['user_id'] = $user->id;
                        $dataCommentCreate['email'] = $user->email;
                        $dataCommentCreate['name'] = $user->name;
                    } else {
                        $dataCommentCreate['email'] = $request->email;
                        $dataCommentCreate['name'] = $request->name;
                    }

                    //  dd($dataCommentCreate);
                    // insert database in comments table by createMany
                    $commentOf->comments()->create($dataCommentCreate);
                    DB::commit();
                    $dataComment = $commentOf->comments()->where('active',1)->latest()->paginate(20);
                    $countComment = $commentOf->comments()->where('active',1)->count();
                    return response()->json([
                        "code" => 200,
                        'data' => view('frontend.components.comment.load-list-comment', [
                            'dataComment' => $dataComment,
                            'countComment' => $countComment,
                        ])->render(),
                        "message" => "success"
                    ], 200);
                } catch (\Exception $exception) {
                    DB::rollBack();
                    Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                    return response()->json([
                        "code" => 500,
                        'data' => false,
                        "message" => "error"
                    ], 500);
                }
            }




            try {
                DB::beginTransaction();

                $dataCommentCreate = [
                    "content" => $request->input('content'),
                    "parent_id" => $request->input('parent_id') ?? 0,
                    'user_id' =>  0,
                    'active'=>0
                ];
                if ($request->has('image_path') && $request->image_path) {
                    $dataUploadImage = $this->storageTraitUpload($request, "image_path", "comment");
                    if (!empty($dataUploadImage)) {
                        $dataCommentCreate["image_path"] = $dataUploadImage["file_path"];
                    }
                }
                if (Auth::check()) {
                    $user = auth()->user();
                    $dataCommentCreate['user_id'] = $user->id;
                    $dataCommentCreate['email'] = $user->email;
                    $dataCommentCreate['name'] = $user->name;
                } else {
                    return;
                }

                // dd($dataCommentCreate);
                // insert database in comments table by createMany
                $commentOf->comments()->create($dataCommentCreate);
                DB::commit();
                return redirect()->route($this->getRouteRedirect(), ['id' => $commentOf->id, 'slug' => $commentOf->slug])->with("alert", "Thêm bình luận thành công! Đang chờ admin duyệt");
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route($this->getRouteRedirect(), ['id' => $commentOf->id, 'slug' => $commentOf->slug])->with("alert", "Thêm bình luận không thành công");
            }
        }
    }

}
