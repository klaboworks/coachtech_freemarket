<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $columns = collect(['condition']);
        $values = collect([
            ['良好'],
            ['目立った傷や汚れなし'],
            ['やや傷や汚れあり'],
            ['状態が悪い'],
        ]);

        $rows = $values->map(fn($x) => $columns->combine($x))->toArray();

        array_walk($rows, function (&$row) {
            $now = Carbon::now();
            $row = array_merge($row, ['created_at' => $now, 'updated_at' => $now]);
        });

        DB::table('conditions')->insert($rows);
    }
}
