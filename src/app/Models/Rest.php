<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = ['attendance_id', 'breakIn', 'breakOut'];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function getTotalBreakTimeAttribute()
{
    // attendance に紐づく rests を取得
    $rests = $this->attendance->rests;

    if ($rests->isNotEmpty()) { // rests が空でない場合のみ計算
        // 休憩時間の合計を計算 (分単位)
        $totalBreakTimeInMinutes = $rests->sum(function ($rest) {
            return $rest->breakIn && $rest->breakOut
                ? Carbon::parse($rest->breakOut)->diffInMinutes(Carbon::parse($rest->breakIn))
                : 0;
        });

        return floor($totalBreakTimeInMinutes / 60) . ':' . str_pad($totalBreakTimeInMinutes % 60, 2, '0', STR_PAD_LEFT);
    } else {
        return '00:00'; // rests が空の場合は '00:00' を返す
    }
}


}
