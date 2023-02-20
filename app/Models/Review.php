<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = "reviews";
    protected $guarded = [];

    /**
     * status 0 -> chưa xử lý
     * status 1 -> nhận sách
     * status 2 -> đã nhận sách
     * status 3 -> nhận điểm
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // get images by relationship 1-nhieu  1 product có nhiều images sử dụng hasMany
    public function images()
    {
        return $this->hasMany(ReviewImage::class, "review_id", "id");
    }
    public function points()
    {
        return $this->hasMany(Point::class, "userorigin_id", "id");
    }
    public function comments()
    {
        return $this->hasMany(ReviewComment::class, "review_id", "id");
    }
    public function countComment()
    {
        return $this->hasMany(ReviewComment::class, "review_id", "id")->select(ReviewComment::raw('COUNT(id) as total'))->first();
    }
}
