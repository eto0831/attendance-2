<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rest;
use Carbon\Carbon;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = Carbon::now()->subDays(2); // 前々日

        return [
            'attendance_id' => null, // 後でAttendanceモデルと紐付ける
            'rest_date' => $date->toDateString(),
            'breakIn' => $date->setTime(15, 0, 0)->toDateTimeString(),
            'breakOut' => null,
        ];
    }
}
