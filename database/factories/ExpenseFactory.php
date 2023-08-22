<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->realText(20),
            'occurrence_date' => Carbon::now()->format("Y-m-d"),
            'user_id' => $this->getRandomUserId(),
            'value' => fake()->numberBetween(1,100),
        ];
    }

    private function getRandomUserId(): int
    {
        return User::select('id')->inRandomOrder()->first()->id ?? 1;
    }
}
