<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CinemaRoom;
use App\Models\Seat;
use Carbon\Carbon;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $rows = range('A', 'H'); // 8 hàng
        $columns = range(1, 10); // 10 ghế mỗi hàng

        $cinemaRooms = CinemaRoom::all();
        $now = Carbon::now();

        foreach ($cinemaRooms as $room) {
            foreach ($rows as $row) {
                foreach ($columns as $column) {
                    Seat::create([
                        'cinema_room_id' => $room->id,
                        'seat_number' => $row . $column,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }
}
