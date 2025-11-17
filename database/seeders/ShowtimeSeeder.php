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

        // Phân bổ giá theo khung giờ (đơn vị: đồng)
        $priceByHour = [
            8  => 45000, // 8h sáng → Rẻ nhất
            11 => 45000, // 11h sáng → Rẻ
            14 => 55000, // 2h chiều → Trung bình
            17 => 65000, // 5h chiều → Đắt
            20 => 65000, // 8h tối → Đắt nhất
        ];

        foreach ($cinemaRooms as $room) {
            // Duyệt 7 ngày tới
            for ($dayOffset = 0; $dayOffset < 7; $dayOffset++) {
                $date = Carbon::now()->startOfDay()->addDays($dayOffset);

                // 5 suất/ngày: 8h, 11h, 14h, 17h, 20h
                $times = [8, 11, 14, 17, 20];

                foreach ($times as $hour) {
                    $startTime = $date->copy()->setTime($hour, 0);

                    Showtime::create([
                        'movie_id'       => $movies[array_rand($movies)],
                        'theater_id'     => $room->theater_id,
                        'cinema_room_id' => $room->id,
                        'start_time'     => $startTime,
                        'ticket_price'   => $priceByHour[$hour], // Giá cố định theo giờ
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            }
        }
    }
}