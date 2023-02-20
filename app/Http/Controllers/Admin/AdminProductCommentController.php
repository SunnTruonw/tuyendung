<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Models\ProductComment;

class AdminProductCommentController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $comment;
    private $settingConfig=[
        'model'=>'product',
        'permissionActive'=>'comment-product-active',
        'permissionDelete'=>'comment-product-delete',
        'routeActive'=>'admin.product.loadActiveComment',
        'routeDelete'=>'admin.product.comment.destroy',
        'routeList'=>'admin.product.comment.index',
    ];
    public function __construct(
        ProductComment $comment
    ) {
        $this->comment = $comment;
    }
    public function index(Request $request)
    {
        $data = $this->comment;
        $where = [];
        if ($request->input('keyword')) {
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $data = $data->where([
                ['content', 'like', '%' . request()->input('keyword') . '%']
            ]);
        }
        if ($where) {
            $data = $data->where($where);
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }

        $data = $data->paginate(15);

        return view("admin.pages.comment.list",
            [
                'data' => $data,
                'settingConfig'=>$this->settingConfig,
                //  'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
                'fill_status' => $request->input('fill_status') ? $request->input('fill_status') : "",
                'fill_active' => $request->input('fill_active') ? $request->input('fill_active') : "",
            ]
        );
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->comment, $id);
    }
    public function loadActiveComment($id)
    {
        $comment   =  $this->comment->find($id);
        $active = $comment->active;
        if (!$active) {
            $activeUpdate = 1;
        } else {
            return;
        }
        $updateResult =  $comment->update([
            'active' => $activeUpdate,
        ]);
        // dd($updateResult);
        $comment   =  $this->comment->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.pages.comment.load-change-active-comment', ['data' => $comment,'routeActive'=>$this->settingConfig['routeActive']])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
