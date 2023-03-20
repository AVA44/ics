<?php

use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 60; $i++) {

            $inventory_id = $i;
            $stock = $i * 10;

            DB::table('stocks')->insert([
                [
                    'inventory_id' => $inventory_id,
                    'stock' => $stock,
                ],
            ]);
        };
    }
}
