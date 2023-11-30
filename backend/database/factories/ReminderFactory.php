<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReminderFactory extends Factory
{
    protected $model = Reminder::class;

    public function definition(): array
    {

        $categoryId = Category::all()->random()->id;
        $createdBy = Category::find($categoryId)->created_by;

        return [
            'created_by' => $createdBy,
            'category_id' => $categoryId,
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'repeat_type' => $this->faker->randomElement(['once', 'daily', 'weekly', 'monthly', 'yearly']),
            'notification_date_time' => Carbon::now()->addDays(rand(1, 3))->addHours(rand(1, 24))->addMinutes(rand(1, 60)),
            'deadline_date_time' => Carbon::now()->addDays(rand(4, 5))->addHours(rand(1, 24))->addMinutes(rand(1, 60)),
            'is_done' => $this->faker->boolean(),
            'is_important' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
