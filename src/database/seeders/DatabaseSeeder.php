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
        // 既存のユーザーを取得
        $users = User::all();

        // 最初の20人の出勤データを作成
        foreach ($users->slice(0, 20) as $user) {
            Attendance::factory()->create(['user_id' => $user->id]);
        }

        // 後半20人の出勤データと休憩データを作成
        foreach ($users->slice(20) as $user) {
            $attendance = Attendance::factory()->create(['user_id' => $user->id]);
            $attendance->rests()->create(Rest::factory()->make()->toArray());
        }

        
    }
}
