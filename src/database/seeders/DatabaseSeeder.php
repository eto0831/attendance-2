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
        $users = User::factory(35)->create();

        // popo1〜popo5: 7日前から前日まで、毎日9時から18時まで出勤、12時から1時間と15時から15分休憩、18時退勤
        for ($i = 0; $i < 5; $i++) {
            for ($j = 7; $j > 0; $j--) {
                $attendance = Attendance::factory()->create([
                    'user_id' => $users[$i]->id,
                    'date' => now()->subDays($j)->toDateString(),
                    'punchIn' => now()->subDays($j)->setTime(9, 0, 0)->toDateTimeString(),
                    'punchOut' => now()->subDays($j)->setTime(18, 0, 0)->toDateTimeString(),
                ]);
                Rest::factory()->create([
                    'attendance_id' => $attendance->id,
                    'rest_date' => now()->subDays($j)->toDateString(),
                    'breakIn' => now()->subDays($j)->setTime(12, 0, 0)->toDateTimeString(),
                    'breakOut' => now()->subDays($j)->setTime(13, 0, 0)->toDateTimeString(),
                ]);
                Rest::factory()->create([
                    'attendance_id' => $attendance->id,
                    'rest_date' => now()->subDays($j)->toDateString(),
                    'breakIn' => now()->subDays($j)->setTime(15, 0, 0)->toDateTimeString(),
                    'breakOut' => now()->subDays($j)->setTime(15, 15, 0)->toDateTimeString(),
                ]);
            }
        }

        // popo6〜popo10: 7日前から前日まで、毎日9時から18時まで出勤、12時から1時間休憩、18時退勤
        for ($i = 5; $i < 10; $i++) {
            for ($j = 7; $j > 0; $j--) {
                $attendance = Attendance::factory()->create([
                    'user_id' => $users[$i]->id,
                    'date' => now()->subDays($j)->toDateString(),
                    'punchIn' => now()->subDays($j)->setTime(9, 0, 0)->toDateTimeString(),
                    'punchOut' => now()->subDays($j)->setTime(18, 0, 0)->toDateTimeString(),
                ]);
                Rest::factory()->create([
                    'attendance_id' => $attendance->id,
                    'rest_date' => now()->subDays($j)->toDateString(),
                    'breakIn' => now()->subDays($j)->setTime(12, 0, 0)->toDateTimeString(),
                    'breakOut' => now()->subDays($j)->setTime(13, 0, 0)->toDateTimeString(),
                ]);
            }
        }

        // popo11〜popo15: 前々日9時から出勤したままの状態
        for ($i = 10; $i < 15; $i++) {
            Attendance::factory()->create([
                'user_id' => $users[$i]->id,
                'date' => now()->subDays(2)->toDateString(),
                'punchIn' => now()->subDays(2)->setTime(9, 0, 0)->toDateTimeString(),
            ]);
        }

        // popo16〜popo20: 前々日9時から出勤、15時から休憩入りのままの状態
        for ($i = 15; $i < 20; $i++) {
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

        // popo21〜popo25: 前日9時から出勤したままの状態
        for ($i = 20; $i < 25; $i++) {
            Attendance::factory()->create([
                'user_id' => $users[$i]->id,
                'date' => now()->subDay()->toDateString(),
                'punchIn' => now()->subDay()->setTime(9, 0, 0)->toDateTimeString(),
            ]);
        }

        // popo26〜popo30: 前日9時から出勤、15時から休憩入りのままの状態
        for ($i = 25; $i < 30; $i++) {
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

        // popo31〜popo35: 前日9時から出勤、12時から1時間休憩と15時から15分休憩、18時退勤
        for ($i = 30; $i < 35; $i++) {
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
