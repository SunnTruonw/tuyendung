<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewComment extends Model
{
    //
    protected $table = "review_comments";
    // public $fillable =['name'];
    protected $guarded = [];

    public function childs()
    {
        return $this->hasMany(ReviewComment::class, 'parent_id', 'id');
    }
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
