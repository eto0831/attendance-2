<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attendance_id' => null, // 後でAttendanceモデルと紐付ける
            'rest_date' => '2024-09-09',
            'breakIn' => '2024-09-09 15:00:00',
            'breakOut' => null,
        ];
    }
}
