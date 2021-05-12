<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //
    protected $table="points";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function userOriginPoint()
    {
        return $this->belongsTo(User::class, 'userorigin_id', 'id');
    }

    // lấy tổng số điểm mỗi kiểu
    // lấy danh sách hoa hồng được hưởng từ các thành viên
    public function sumEachType($userId)
    {
        return  $this->where([
            'user_id' => $userId,
        ])->select('type', Point::raw('SUM(point) as total'))->groupBy('type')->get();
    }

     // lấy số điểm hiện có
    public function sumPointCurrent($userId)
    {
        return $this->where([
            'user_id' => $userId,
        ])->select(Point::raw('SUM(point) as total'))->first()->total;
    }
}
