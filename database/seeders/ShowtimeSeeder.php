<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\CinemaRoom;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::pluck('id')->toArray();
        $cinemaRooms = CinemaRoom::with('theater')->get();

        foreach ($cinemaRooms as $room) {
            // Duyệt qua 7 ngày tới (từ hôm nay)
            for ($dayOffset = 0; $dayOffset < 7; $dayOffset++) {
                $date = Carbon::now()->startOfDay()->addDays($dayOffset);

                // Tạo 5 suất chiếu mỗi ngày: 8h, 11h, 14h, 17h, 20h
                $times = [8, 11, 14, 17, 20];

                foreach ($times as $hour) {
                    Showtime::create([
                        'movie_id' => $movies[array_rand($movies)],
                        'theater_id' => $room->theater_id,
                        'cinema_room_id' => $room->id,
                        'start_time' => $date->copy()->addHours($hour),
                        'ticket_price' => rand(70000, 120000),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
