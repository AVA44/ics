<?php

use Illuminate\Database\Seeder;

class StockDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        date_default_timezone_set('UTC');
        $start = strtotime('2023-01-01');
        $end = strtotime('2024-12-31');

        for ($i = 1; $i <= 60; $i++) {

            $inventory_id = $i;
            $stock_data_id = $i;
            $expired_at = date('Y-m-d', rand($start, $end));
            $limited_at = date('Y-m-d', strtotime("$expired_at -45 day"));

            switch (true) {
                case $i <= 10:
                    $taste_name = 'グレープ';
                    break;
                case $i <= 20:
                    $taste_name = 'コーラ';
                    break;
                case $i <= 30:
                    $taste_name = 'ソーダ';
                    break;
                case $i <= 40:
                    $taste_name = 'しお';
                    break;
                case $i <= 50:
                    $taste_name = 'しょうゆ';
                    break;
                case $i <= 60:
                    $taste_name = '宇宙人';
                    break;
            }

            DB::table('stocks_data')->insert([
                [
                    'inventory_id' => $inventory_id,
                    'stock_data_id' => $stock_data_id,
                    'expired_at' => $expired_at,
                    'limited_at' => $limited_at,
                    'taste_name' => $taste_name,
                ]
            ]);
        };
    }
}
