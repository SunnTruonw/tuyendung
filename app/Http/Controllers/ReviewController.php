<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Helper\CountView;

class ReviewController extends Controller
{
    //
    private $review;
    private $countView;
    public function __construct(Review $review, CountView $countView)
    {
        $this->review = $review;
        $this->countView = $countView;
    }
    public function index()
    {
        //  dd($category);
        $data = $this->review->where('active', 1)->latest()->paginate(20);
        return view('frontend.pages.review.review-list', [
            'data' => $data,
            'seo' => [
                'title' =>   "Danh sách review",
                'keywords' =>   "Danh sách review",
                'description' =>  "Danh sách review",
                'image' => "",
                'abstract' =>   "Danh sách review",
            ]
        ]);
    }
    public function detail($slug, $id)
    {
        //  dd($category);
        $data = $this->review->where([
            ['active', 1],
            ['id', $id],
            ['slug', $slug]
        ])->first();

        if ($data) {
            $this->countView->countView($this->review, 'view', 'review', $id);
            $dataComment = $data->comments()->where('active',1)->with('user')->latest()->paginate(20);
            $countComment = $data->comments()->where('active',1)->count();
            return view('frontend.pages.review.review-detail', [
                'data' => $data,
                'dataComment' => $dataComment,
                'countComment' => $countComment,
                'seo' => [
                    'title' =>   "Danh sách review",
                    'keywords' =>   "Danh sách review",
                    'description' =>  "Danh sách review",
                    'image' => "",
                    'abstract' =>   "Danh sách review",
                ]
            ]);
        }
    }
    public function preview($id)
    {

        //  dd($category);
        $data = $this->review->where([
            ['id', $id],
        ])->first();

        if ($data) {
            $this->countView->countView($this->review, 'view', 'review', $id);
            $dataComment = $data->comments()->with('user')->latest()->paginate(20);
            $countComment = $data->comments()->count();
            return view('frontend.pages.review.review-detail', [
                'data' => $data,
                'dataComment' => $dataComment,
                'countComment' => $countComment,
                'seo' => [
                    'title' =>   "Danh sách review",
                    'keywords' =>   "Danh sách review",
                    'description' =>  "Danh sách review",
                    'image' => "",
                    'abstract' =>   "Danh sách review",
                ]
            ]);
        }
    }
}
