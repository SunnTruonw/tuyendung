<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewComment;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Traits\CommentTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReviewCommentController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait,CommentTrait;
    private $reviewComment;
    private $review;


    public function __construct(
        ReviewComment $reviewComment,
        Review $review
    ) {
        $this->reviewComment = $reviewComment;
        $this->review = $review;
    }

    public function store($slug,$id, Request $request)
    {
       return $this->storeComment($this->review,$slug,$id,$request);
    }
       public function getRouteRedirect(){
        return 'review.detail';
    }
}
