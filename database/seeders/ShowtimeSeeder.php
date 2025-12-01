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
        $movieIds = Movie::pluck('id')->toArray();
        if (empty($movieIds)) {
            $this->command->error('Không có phim nào trong CSDL!');
            return;
        }

        $cinemaRooms = CinemaRoom::with('theater')->get();

        // KHUNG GIỜ SIÊU DÀY – CHUẨN RẠP VIỆT NAM 2025
        $timeSlots = [
            // Thứ 2 → Thứ 5: rất dày (12–15 suất/phòng)
            'weekday' => [
                '09:00','09:40','10:20','11:00','11:40',
                '12:20','13:00','13:40','14:20','15:00',
                '15:40','16:20','17:00','17:40','18:20',
                '19:00','19:40','20:20','21:00','21:40',
                '22:20','23:00','23:40'
            ],
            // Thứ 6: dày hơn nữa
            'friday' => [
                '09:00','09:40','10:20','11:00','11:40',
                '12:20','13:00','13:40','14:20','15:00',
                '15:40','16:20','17:00','17:40','18:20',
                '19:00','19:40','20:20','21:00','21:40',
                '22:20','23:00','23:40','00:20'
            ],
            // Thứ 7, CN: banh nóc luôn (20–24 suất/phòng)
            'weekend' => [
                '08:30','09:10','09:50','10:30','11:10',
                '11:50','12:30','13:10','13:50','14:30',
                '15:10','15:50','16:30','17:10','17:50',
                '18:30','19:10','19:50','20:30','21:10',
                '21:50','22:30','23:10','23:50','00:30','01:00'
            ],
        ];

        // Giá vé tăng dần theo suất (sáng rẻ → tối đắt → khuya rẻ lại)
        $prices = [
            'weekday' => [45000,50000,55000,65000,75000,85000,95000,95000,85000,75000,65000,55000],
            'friday'  => [55000,65000,75000,85000,95000,105000,115000,115000,105000,95000,85000,75000],
            'weekend' => [75000,85000,95000,105000,115000,130000,145000,145000,135000,125000,115000,105000,95000],
        ];

        foreach ($cinemaRooms as $room) {
            $theaterId = $room->theater_id;

            for ($dayOffset = 0; $dayOffset < 14; $dayOffset++) {
                $date = Carbon::now()->startOfDay()->addDays($dayOffset);
                $dayOfWeek = $date->dayOfWeek;

                $dayType = 'weekday';
                if (in_array($dayOfWeek, [0, 6])) $dayType = 'weekend';
                elseif ($dayOfWeek == 5) $dayType = 'friday';

                $slots = $timeSlots[$dayType];
                $priceList = $prices[$dayType];

                foreach ($slots as $index => $timeStr) {
                    $startTime = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d') . ' ' . $timeStr);

                    // Chỉ bỏ suất sau 1h sáng (rạp nào cũng đóng cửa 1h30–2h)
                    if ($startTime->format('H') >= 1 && $dayType !== 'weekend') {
                        continue;
                    }

                    $movieId = $movieIds[array_rand($movieIds)];

                    // Giá theo suất thứ mấy trong ngày
                    $priceIndex = min($index, count($priceList) - 1);
                    $price = $priceList[$priceIndex];

                    // Tránh trùng giờ trong cùng rạp (giãn 15–20 phút)
                    $conflict = Showtime::where('theater_id', $theaterId)
                        ->whereBetween('start_time', [
                            $startTime->copy()->subMinutes(20),
                            $startTime->copy()->addMinutes(20)
                        ])
                        ->where('cinema_room_id', '!=', $room->id)
                        ->exists();

                    if ($conflict && rand(1, 100) <= 70) { // 70% bỏ nếu trùng
                        continue;
                    }

                    Showtime::create([
                        'movie_id'       => $movieId,
                        'theater_id'     => $theaterId,
                        'cinema_room_id' => $room->id,
                        'start_time'     => $startTime,
                        'ticket_price'   => $price,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            }
        }

        $this->command->info('Showtime seeding completed!');
    }
}