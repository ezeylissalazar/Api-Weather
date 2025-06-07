<?php

namespace Database\Seeders;

use App\Models\FavoriteCity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'demo@example.com')->first();

        if (!$user) {
            $this->command->error('Usuario demo no encontrado, ejecuta primero UsersSeeder');
            return;
        }

        $cities = ['Quito', 'Guayaquil', 'Cuenca', 'Loja'];

        foreach (array_slice($cities, 0, 2) as $city) {
            FavoriteCity::create([
                'user_id' => $user->id,
                'city' => $city,
            ]);
        }
    }
}
