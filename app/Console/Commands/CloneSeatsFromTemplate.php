<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\CinemaRoom;
use App\Models\RoomTemplateSeat;
use App\Models\Seat;
use Carbon\Carbon;

class CloneSeatsFromTemplate extends Command
{
    protected $signature = 'cinema:clone-seats 
                            {--truncate-seats : Truncate seats table before cloning}
                            {--room_id= : Clone seats only for a specific room}';

    protected $description = 'Clone seats from room templates into seats table';

    public function handle()
    {
        $truncate = $this->option('truncate-seats');
        $roomId = $this->option('room_id');

        if ($truncate) {
            $this->info("Truncating seats table...");
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Seat::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        DB::transaction(function () use ($roomId) {
            $rooms = CinemaRoom::query();
            if ($roomId) $rooms->where('id', $roomId);
            $rooms = $rooms->get();

            foreach ($rooms as $room) {
                if (!$room->room_template_id) {
                    $this->warn("Room {$room->id} has no template → skip.");
                    continue;
                }

                if (Seat::where('cinema_room_id', $room->id)->exists()) {
                    $this->warn("Room {$room->id} already has seats → skip.");
                    continue;
                }

                $templateSeats = RoomTemplateSeat::where('room_template_id', $room->room_template_id)->get();
                $now = now();

                $this->info("Cloning {$templateSeats->count()} seats → Room {$room->id}");

                $insert = [];
                foreach ($templateSeats as $ts) {
                    $insert[] = [
                        'cinema_room_id' => $room->id,
                        'seat_number' => $ts->seat_number,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                foreach (array_chunk($insert, 300) as $chunk) {
                    DB::table('seats')->insert($chunk);
                }
            }
        });

        $this->info("DONE!");
        return 0;
    }
}
