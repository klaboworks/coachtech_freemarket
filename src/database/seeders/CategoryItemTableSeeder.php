<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CategoryItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $param = ['category_id' => 1, 'item_id' => 1];
        // DB::table('categories_items')->insert($param);

        $columns = collect(['item_id', 'category_id']);
        $values = collect([
            [1, 1],
            [1, 5],
            [1, 12],
            [2, 2],
            [3, 10],
            [4, 1],
            [4, 5],
            [5, 2],
            [6, 2],
            [7, 1],
            [7, 4],
            [7, 12],
            [8, 10],
            [9, 3],
            [9, 10],
            [10, 6],
        ]);

        $rows = $values->map(fn($x) => $columns->combine($x))->toArray();

        array_walk($rows, function (&$row) {
            $now = Carbon::now();
            $row = array_merge($row, ['created_at' => $now, 'updated_at' => $now]);
        });

        DB::table('category_item')->insert($rows);
    }
}
