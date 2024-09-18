<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 出勤状態を取得するメソッドを追加
    public function getAttendanceStatus()
    {
        // 今日の出勤記録を取得
        $attendance = Attendance::where('user_id', $this->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$attendance || !$attendance->punchIn) {
            // 出勤打刻がない場合は状態 1
            return 1;
        } elseif (!$attendance->punchOut) {
            // 出勤済みで退勤打刻がない場合

            // 今日の休憩記録を取得
            $rests = Rest::where('attendance_id', $attendance->id)
                ->whereDate('rest_date', Carbon::today()) // created_at ではなく date で検索
                ->get();

            if ($rests->isEmpty()) {
                // 休憩記録が全くない場合は状態 2
                return 2;
            } else {
                // 休憩記録がある場合は、全て breakOut 済みかどうかを確認
                $allBreaksEnded = $rests->every(function ($rest) {
                    return $rest->breakOut !== null;
                });

                if ($allBreaksEnded) {
                    // 全ての休憩が終了している場合は状態 3
                    return 3;
                } else {
                    // 未終了の休憩がある場合は状態 4
                    return 4;
                }
            }
        } else {
            // 退勤打刻済みの場合は状態 5
            return 5;
        }
    }
}
