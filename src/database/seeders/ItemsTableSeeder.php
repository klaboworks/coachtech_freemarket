<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $columns = collect(['condition_id', 'user_id', 'item_image', 'item_name', 'price', 'item_description', 'is_sold']);
        $values = collect([
            [1, 1, 'Armani+Mens+Clock.jpg', '腕時計', 15000, 'スタイリッシュなデザインのメンズ腕時計', false],
            [2, 1, 'HDD+Hard+Disk.jpg', 'HDD', 5000, '高速で信頼性の高いハードディスク', false],
            [3, 1, 'iLoveIMG+d.jpg', '玉ねぎ3束', 300, '新鮮な玉ねぎ3束のセット', false],
            [4, 2, 'Leather+Shoes+Product+Photo.jpg', '革靴', 4000, 'クラシックなデザインの革靴', true],
            [1, 2, 'Living+Room+Laptop.jpg', 'ノートPC', 45000, '高性能なノートパソコン', false],
            [2, 2, 'Music+Mic+4632231.jpg', 'マイク', 8000, '高音質のレコーディング用マイク', false],
            [3, 3, 'Purse+fashion+pocket.jpg', 'ショルダーバッグ', 3500, 'おしゃれなショルダーバッグ', false],
            [4, 3, 'Tumbler+souvenir.jpg', 'タンブラー', 500, '使いやすいタンブラー', false],
            [1, 3, 'Waitress+with+Coffee+Grinder.jpg', 'コーヒーミル', 4000, '手動のコーヒーミル', false],
            [2, 1, '外出メイクアップセット.jpg', 'メイクセット', 2500, '便利なメイクアップセット', false],
        ]);

        $rows = $values->map(fn($x) => $columns->combine($x))->toArray();

        array_walk($rows, function (&$row) {
            $now = Carbon::now();
            $row = array_merge($row, ['created_at' => $now, 'updated_at' => $now]);
        });

        DB::table('items')->insert($rows);
    }
}
