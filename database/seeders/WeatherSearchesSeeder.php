<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeatherSearch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WeatherSearchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $user = User::where('email', 'demo@example.com')->first();

        if (!$user) {
            $this->command->error('Usuario demo no encontrado, corre UsersSeeder primero');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            WeatherSearch::create([
                'user_id' => $user->id,
                'city' => $faker->city(),
                'data' => [
                    'temperature' => $faker->numberBetween(10, 30),
                    'condition' => $faker->randomElement(['Soleado', 'Nublado', 'Lluvioso']),
                    'wind_kph' => $faker->numberBetween(0, 40),
                    'humidity' => $faker->numberBetween(30, 100),
                    'local_time' => $faker->dateTimeThisYear()->format('Y-m-d H:i'),
                ],
            ]);
        }
    }
}
