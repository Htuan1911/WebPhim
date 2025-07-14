<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CinemaRoomSeeder::class,
            SeatSeeder::class,
            ShowtimeSeeder::class,
        ]);
    }
}
