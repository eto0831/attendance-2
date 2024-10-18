<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'punchIn', 'punchOut'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    //↓この部分は０時またぎように追加
    protected $casts = [
        'date' => 'date',
        'punchIn' => 'datetime',
        'punchOut' => 'datetime',
    ];

    public function scopeDateSearch($query, $date)
    {
        if (!empty($date)) {
            return $query->whereDate('date', $date);
        }
    }

    public function getTotalWorkingTimeAttribute()
{
    if ($this->punchIn && $this->punchOut) {
        $punchInTime = Carbon::parse($this->punchIn);
        $punchOutTime = Carbon::parse($this->punchOut);
        $totalWorkingTime = $punchOutTime->diffInSeconds($punchInTime);

        $totalBreakTime = $this->rests->sum(function ($rest) {
            return $rest->breakIn && $rest->breakOut
                ? Carbon::parse($rest->breakOut)->diffInSeconds(Carbon::parse($rest->breakIn))
                : 0;
        });

        $actualWorkingTime = $totalWorkingTime - $totalBreakTime;

        $hours = str_pad(floor($actualWorkingTime / 3600), 2, '0', STR_PAD_LEFT); // 時間を計算
        $minutes = str_pad(floor(($actualWorkingTime % 3600) / 60), 2, '0', STR_PAD_LEFT); // 分を計算
        $seconds = str_pad($actualWorkingTime % 60, 2, '0', STR_PAD_LEFT); // 秒を計算

        return $hours . ':' . $minutes . ':' . $seconds;
    } else {
        return null;
    }
}

}
