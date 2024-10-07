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

    //↓この部分は０時またぎように追加バグが起きたら消して
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
            $totalWorkingTime = $punchOutTime->diffInMinutes($punchInTime);

            $totalBreakTime = $this->rests->sum(function ($rest) {
                return $rest->breakIn && $rest->breakOut
                    ? Carbon::parse($rest->breakOut)->diffInMinutes(Carbon::parse($rest->breakIn))
                    : 0;
            });

            $actualWorkingTime = $totalWorkingTime - $totalBreakTime;

            return floor($actualWorkingTime / 60) . ':' . str_pad($actualWorkingTime % 60, 2, '0', STR_PAD_LEFT);
        } else {
            return null;
        }
    }

}
