<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater;
use App\Models\CinemaRoom;

class CinemaRoomSeeder extends Seeder
{
    public function run(): void
    {
        $theaters = Theater::all();

        foreach ($theaters as $theater) {
            for ($i = 1; $i <= 2; $i++) {
                CinemaRoom::create([
                    'theater_id' => $theater->id,
                    'name' => "Phòng $i - {$theater->name}",
                    'total_seats' => $theater->total_seats / 2, // ví dụ chia đều
                ]);
            }
        }
    }
}
