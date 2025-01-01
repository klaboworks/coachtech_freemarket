<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $columns = collect(['category_name']);
        $values = collect([
            ['ファッション'],
            ['家電'],
            ['インテリア'],
            ['レディース'],
            ['メンズ'],
            ['コスメ'],
            ['本'],
            ['ゲーム'],
            ['スポーツ'],
            ['キッチン'],
            ['ハンドメイド'],
            ['アクセサリー'],
            ['おもちゃ'],
            ['ベビー・キッズ'],
        ]);

        $rows = $values->map(fn($x) => $columns->combine($x))->toArray();

        array_walk($rows, function (&$row) {
            $now = Carbon::now();
            $row = array_merge($row, ['created_at' => $now, 'updated_at' => $now]);
        });

        DB::table('categories')->insert($rows);
    }
}
