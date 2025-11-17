<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Theater;
use App\Models\CinemaRoom;
use App\Models\RoomTemplate;
use Carbon\Carbon;

class CinemaRoomSeeder extends Seeder
{
    public function run()
    {
        // Template name bạn muốn dùng
        $templateName = 'Template 80 Seats (8x10)';

        // Tìm template
        $template = RoomTemplate::where('name', $templateName)->first();

        if (!$template) {
            echo "❌ Template '{$templateName}' không tồn tại.\n";
            echo "👉 Chạy: php artisan db:seed --class=RoomTemplateSeeder\n";
            return;
        }

        echo "⚠ Đang tắt khóa ngoại...\n";
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        echo "⚠ Truncate seats...\n";
        DB::table('seats')->truncate();

        echo "⚠ Truncate cinema_rooms...\n";
        DB::table('cinema_rooms')->truncate();

        echo "⚠ Bật lại khóa ngoại...\n";
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "⚠ Đang tạo lại cinema rooms...\n";

        // Phần này MỚI dùng transaction (vì không còn truncate)
        DB::transaction(function () use ($template) {
            $theaters = Theater::all();

            foreach ($theaters as $theater) {
                for ($i = 1; $i <= 2; $i++) {

                    CinemaRoom::create([
                        'theater_id' => $theater->id,
                        'room_template_id' => $template->id,
                        'name' => "Phòng {$i} - {$theater->name}",
                        'total_seats' => $template->rows * $template->columns,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        });

        echo "✅ DONE! Đã tạo phòng theo template '{$templateName}'.\n";
    }
}
