<?php

use Illuminate\Database\Seeder;

class InventoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 60; $i++) {

            // $name
            $name = "景品{$i}";

            // $category_name $parchase
            switch ($i % 5) {
                case 0:
                    $category_name = 'カテゴリ５';
                    $parchase = 50;
                    break;
                case 1:
                    $category_name = 'カテゴリ１';
                    $parchase = 10;
                    break;
                case 2:
                    $category_name = 'カテゴリ２';
                    $parchase = 20;
                    break;
                case 3:
                    $category_name = 'カテゴリ３';
                    $parchase = 30;
                    break;
                case 4:
                    $category_name = 'カテゴリ４';
                    $parchase = 40;
                    break;
            };

            // $box_price $image_url
            switch ($i % 3) {
                case 0:
                    $box_price = 10800;
                    $image_url = 101010;
                    break;
                case 1:
                    $box_price = 24000;
                    $image_url = 010101;
                    break;
                case 2:
                    $box_price = 33200;
                    $image_url = null;
                    break;
            };

            // $unit_price
            $unit_price = round($box_price / $parchase);

            // $lank
            switch ($unit_price) {
                case $unit_price >= 780:
                    $lank = 'A';
                    break;
                case $unit_price >= 680:
                    $lank = 'B';
                    break;
                case $unit_price >= 580:
                    $lank = 'C';
                    break;
                case $unit_price >= 400:
                    $lank = 'D';
                    break;
                case $unit_price >= 300:
                    $lank = 'E';
                    break;
                case $unit_price >= 100:
                    $lank = 'F';
                    break;
                default:
                    $lank = '';
                    break;
            };

            DB::table('inventories')->insert([
                [
                    'name' => $name,
                    'category_name' => $category_name,
                    'parchase' => $parchase,
                    'box_price' => $box_price,
                    'unit_price' => $unit_price,
                    'lank' => $lank,
                    'image_url' => $image_url
                ],
            ]);
        };
    }
}
