<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Traits\CommentTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductCommentController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait,CommentTrait;
    private $productComment;
    private $product;


    public function __construct(
        ProductComment $productComment,
        Product $product
    ) {
        $this->productComment = $productComment;
        $this->product = $product;
    }

    public function store($slug,$id, Request $request)
    {
        return $this->storeComment($this->product,$slug,$id,$request);
    }
    public function getRouteRedirect(){
        return 'product.detail';
    }
}
