<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RoomTemplate;
use App\Models\RoomTemplateSeat;
use Carbon\Carbon;

class RoomTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name' => 'Template 65 Seats (5x13)',
                'rows' => 5,
                'cols' => 13
            ],
            [
                'name' => 'Template 70 Seats (7x10)',
                'rows' => 7,
                'cols' => 10
            ],
            [
                'name' => 'Template 80 Seats (8x10)',
                'rows' => 8,
                'cols' => 10
            ],
            [
                'name' => 'Template 90 Seats (9x10)',
                'rows' => 9,
                'cols' => 10
            ],
            [
                'name' => 'Template 120 Seats (10x12)',
                'rows' => 10,
                'cols' => 12
            ],
        ];

        foreach ($templates as $tpl) {
            $this->createTemplate($tpl['name'], $tpl['rows'], $tpl['cols']);
        }
    }

    private function createTemplate($name, $rows, $cols)
    {
        DB::transaction(function () use ($name, $rows, $cols) {

            $template = RoomTemplate::firstOrCreate(
                ['name' => $name],
                [
                    'rows' => $rows,
                    'columns' => $cols,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            // Nếu đã có seat mẫu thì bỏ qua
            if (RoomTemplateSeat::where('room_template_id', $template->id)->exists()) {
                echo "⚠ Template '{$name}' already exists → skip\n";
                return;
            }

            $alphabet = range('A', 'Z');
            $insert = [];

            for ($r = 0; $r < $rows; $r++) {
                $rowLetter = $alphabet[$r]; // A, B, C...

                for ($c = 1; $c <= $cols; $c++) {
                    $insert[] = [
                        'room_template_id' => $template->id,
                        'seat_number' => $rowLetter . $c,
                        'type' => 'normal',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            foreach (array_chunk($insert, 200) as $chunk) {
                RoomTemplateSeat::insert($chunk);
            }

            echo "✅ Created Template: {$name} ({$rows}x{$cols}) = " . ($rows * $cols) . " seats\n";
        });
    }
}
