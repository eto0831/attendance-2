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
    $rests = $this->attendance->rests;

    if ($rests->isNotEmpty()) {
        $totalBreakTimeInSeconds = $rests->sum(function ($rest) {
            return $rest->breakIn && $rest->breakOut
                ? Carbon::parse($rest->breakOut)->diffInSeconds(Carbon::parse($rest->breakIn))
                : 0;
        });

        $hours = floor($totalBreakTimeInSeconds / 3600);
        $minutes = floor(($totalBreakTimeInSeconds % 3600) / 60);
        $seconds = $totalBreakTimeInSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    } else {
        return '00:00:00';
    }
}


}
