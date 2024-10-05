<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //ユーザー作成
        $users = User::factory(30)->create();

        // popo1〜popo5: 前々日午前9時から出勤
        for ($i = 0; $i < 5; $i++) {
            Attendance::factory()->create([
                'user_id' => $users[$i]->id,
                'date' => now()->subDays(2)->toDateString(),
                'punchIn' => now()->subDays(2)->setTime(9, 0, 0)->toDateTimeString(),
            ]);
        }

        // popo6〜popo10: 前々日午前9時から出勤、休憩入り
        for ($i = 5; $i < 10; $i++) {
            $attendance = Attendance::factory()->create([
                'user_id' => $users[$i]->id,
                'date' => now()->subDays(2)->toDateString(),
                'punchIn' => now()->subDays(2)->setTime(9, 0, 0)->toDateTimeString(),
            ]);
            Rest::factory()->create([
                'attendance_id' => $attendance->id,
                'rest_date' => now()->subDays(2)->toDateString(),
                'breakIn' => now()->subDays(2)->setTime(15, 0, 0)->toDateTimeString(),
            ]);
        }

        // popo11〜popo15: 前日午前9時から出勤
        for ($i = 10; $i < 15; $i++) {
            Attendance::factory()->create([
                'user_id' => $users[$i]->id,
                'date' => now()->subDay()->toDateString(),
                'punchIn' => now()->subDay()->setTime(9, 0, 0)->toDateTimeString(),
            ]);
        }

        // popo16〜popo20: 前日午前9時から出勤、休憩入り
        for ($i = 15; $i < 20; $i++) {
            $attendance = Attendance::factory()->create([
                'user_id' => $users[$i]->id,
                'date' => now()->subDay()->toDateString(),
                'punchIn' => now()->subDay()->setTime(9, 0, 0)->toDateTimeString(),
            ]);
            Rest::factory()->create([
                'attendance_id' => $attendance->id,
                'rest_date' => now()->subDay()->toDateString(),
                'breakIn' => now()->subDay()->setTime(15, 0, 0)->toDateTimeString(),
            ]);
        }

        // popo21〜popo25: 前日午前9時から出勤、休憩入り1時間で休憩終了18時退勤
        for ($i = 20; $i < 25; $i++) {
            $attendance = Attendance::factory()->create([
                'user_id' => $users[$i]->id,
                'date' => now()->subDay()->toDateString(),
                'punchIn' => now()->subDay()->setTime(9, 0, 0)->toDateTimeString(),
                'punchOut' => now()->subDay()->setTime(18, 0, 0)->toDateTimeString(),
            ]);
            Rest::factory()->create([
                'attendance_id' => $attendance->id,
                'rest_date' => now()->subDay()->toDateString(),
                'breakIn' => now()->subDay()->setTime(12, 0, 0)->toDateTimeString(),
                'breakOut' => now()->subDay()->setTime(13, 0, 0)->toDateTimeString(),
            ]);
            Rest::factory()->create([
                'attendance_id' => $attendance->id,
                'rest_date' => now()->subDay()->toDateString(),
                'breakIn' => now()->subDay()->setTime(15, 0, 0)->toDateTimeString(),
                'breakOut' => now()->subDay()->setTime(15, 15, 0)->toDateTimeString(),
            ]);
        }
    }
}
