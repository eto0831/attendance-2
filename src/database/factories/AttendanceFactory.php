<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceFactory extends Factory
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
            'date' => $date->toDateString(),
            'punchIn' => $date->setTime(9, 0, 0)->toDateTimeString(),
            'punchOut' => null,
        ];
    }
}
