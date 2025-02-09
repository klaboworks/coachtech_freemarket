<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $columns = collect(['payment']);
        $values = collect([
            ['コンビニ支払い'],
            ['カード支払い'],
        ]);

        $rows = $values->map(fn($x) => $columns->combine($x))->toArray();

        array_walk($rows, function (&$row) {
            $now = Carbon::now();
            $row = array_merge($row, ['created_at' => $now, 'updated_at' => $now]);
        });

        DB::table('payments')->insert($rows);
    }
}
