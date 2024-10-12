<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;

use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // ログイン時に未退勤のレコードがあれば自動退勤・出勤処理
        $this->autoPunchOutAndIn(auth()->user());

        $status = auth()->user()->getAttendanceStatus();
        $attendances = Attendance::with('user', 'rests');

        // ボタンの活性/非活性を制御するための情報をビューに渡す
        return view('index', compact('attendances'), [
            'status' => $status,
            'canPunchIn' => $status == 1,
            'canPunchOut' => $status == 2 || $status == 3,
            'canBreakIn' => $status == 2 || $status == 3,
            'canBreakOut' => $status == 4,
        ]);
    }

    public function dailyAttendance(Request $request)
    {
        $searchDate = $request->input('search_date', now()->format('Y-m-d'));
        $currentDate = Carbon::parse($searchDate);
        $previousDate = $currentDate->copy()->subDay()->format('Y-m-d');
        $nextDate = $currentDate->copy()->addDay()->format('Y-m-d');

        $status = auth()->user()->getAttendanceStatus();
        $attendances = Attendance::with('user', 'rests')
            ->whereDate('date', $searchDate)
            ->paginate(5);

        // ボタンの活性/非活性を制御するための情報をビューに渡す
        return view('daily_attendance', compact('attendances'), [
            'status' => $status,
            'canPunchIn' => $status == 1,
            'canPunchOut' => $status == 2 || $status == 3,
            'canBreakIn' => $status == 2 || $status == 3,
            'canBreakOut' => $status == 4,
            'currentDate' => $currentDate->format('Y-m-d'),
            'previousDate' => $previousDate,
            'nextDate' => $nextDate,
        ]);
    }

    public function punchIn(Request $request)
    {
        // 現在のユーザーを取得
        $user = auth()->user();


        // すでに今日の勤務記録があるか確認
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())->first();

        if (!$attendance) {
            // 勤務記録がない場合は新規作成
            $attendance = new Attendance();
            $attendance->user_id = $user->id;
            $attendance->date = Carbon::today();
        }

        // 勤務開始時刻を記録
        $attendance->punchIn = Carbon::now();
        $attendance->save();

        return redirect()->back()->with('my_status', '出勤打刻が完了しました');
    }

    public function punchOut(Request $request)
    {
        // 現在のユーザーを取得
        $user = auth()->user();

        // すでに今日の勤務記録があるか確認
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())->first();

        if (!$attendance) {
            // 勤務記録がない場合は新規作成
            $attendance = new Attendance();
            $attendance->user_id = $user->id;
            $attendance->date = Carbon::today();
        }

        // 勤務開始時刻を記録
        $attendance->punchOut = Carbon::now();
        $attendance->save();

        return redirect()->back()->with('my_status', '退勤打刻が完了しました');
    }

    public function breakIn(Request $request)
    {
        // 現在のユーザーを取得
        $user = auth()->user();

        // 今日のattendanceレコードを取得
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())->first();

        // attendance レコードが存在しない場合はエラー処理
        if (!$attendance) {
            abort(400, 'Attendance record not found.');
        }

        // 新しい休憩レコードを作成
        $rest = new Rest();
        $rest->attendance_id = $attendance->id;
        $rest->rest_date = Carbon::today(); // dateカラムにも値を設定

        // 休憩開始時刻を記録
        $rest->breakIn = Carbon::now();
        $rest->save();

        return redirect()->back()->with('my_status', '休憩入り打刻が完了しました');
    }

    public function breakOut(Request $request)
    {
        // 現在のユーザーを取得
        $user = auth()->user();

        // 今日のattendanceレコードを取得
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())->first();

        // attendance レコードが存在しない場合はエラー処理
        if (!$attendance) {
            abort(400, 'Attendance record not found.');
        }

        // 今日の休憩記録の中で、breakOut が null の最新のものを取得
        $rest = Rest::where('attendance_id', $attendance->id)
            ->whereDate('rest_date', Carbon::today()) // created_atではなく、dateカラムで検索
            ->whereNull('breakOut')
            ->latest() // 最新のレコードを取得
            ->first();

        // 休憩終了時刻を記録
        $rest->breakOut = Carbon::now();
        $rest->save();

        return redirect()->back()->with('my_status', '休憩開け打刻が完了しました');
    }

    public function destroy(Request $request)
    {
        Attendance::find($request->id)->delete();

        return redirect('/')->with('message', '勤務記録を削除しました');
    }

    private function autoPunchOutAndIn(User $user)
    {
        // 最終出勤日が昨日以前 かつ 未退勤のレコードを取得
        $lastAttendance = Attendance::where('user_id', $user->id)
            ->where('date', '<', Carbon::today())
            ->whereNull('punchOut')
            ->latest()
            ->first();

        if ($lastAttendance) {
            // 最終出勤日が昨日以前の場合
            if ($lastAttendance->date->lt(Carbon::yesterday())) {
                // 最終出勤日の当日 0時0分（24:00）で退勤処理
                $lastAttendance->punchOut = $lastAttendance->date->copy()->endOfDay();
                $lastAttendance->save();

                // 最終出勤日の未終了の休憩を取得
                $lastRest = Rest::where('attendance_id', $lastAttendance->id)
                    ->whereNull('breakOut')
                    ->latest()
                    ->first();

                if ($lastRest) {
                    // 未終了の休憩があれば、最終出勤日の当日 0時0分（24:00）で休憩終了処理
                    $lastRest->breakOut = $lastAttendance->date->copy()->endOfDay();
                    $lastRest->save();
                }
                // 以降のレコード作成は行わない
                return;
            }

            // 最終出勤日が昨日の場合
            // 最終出勤日の当日 0時0分（24:00）で退勤処理
            $lastAttendance->punchOut = $lastAttendance->date->copy()->endOfDay();
            $lastAttendance->save();

            // 最終出勤日の未終了の休憩を取得
            $lastRest = Rest::where('attendance_id', $lastAttendance->id)
                ->whereNull('breakOut')
                ->latest()
                ->first();

            if ($lastRest) {
                // 未終了の休憩があれば、最終出勤日の当日 0時0分（24:00）で休憩終了処理
                $lastRest->breakOut = $lastAttendance->date->copy()->endOfDay();
                $lastRest->save();
            }

            // 本日の出勤レコードを作成
            $newAttendance = new Attendance();
            $newAttendance->user_id = $user->id;
            $newAttendance->date = Carbon::today();
            $newAttendance->punchIn = Carbon::today()->startOfDay();
            $newAttendance->save();

            // 前日に未終了の休憩があれば、当日の0時0分に休憩開始のレコードも作成
            if ($lastRest) {
                $newRest = new Rest();
                $newRest->attendance_id = $newAttendance->id;
                $newRest->rest_date = Carbon::today();
                $newRest->breakIn = Carbon::today()->startOfDay();
                $newRest->save();
            }
        }
    }

    public function userAttendance(Request $request)
    {
        $user = User::find($request->id);
        $attendances = Attendance::where('user_id', $user->id)->paginate(5);

        return view('users.user', compact('attendances', 'user'));
    }
}
