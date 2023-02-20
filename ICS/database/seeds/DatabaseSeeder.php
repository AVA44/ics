<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InventoriesSeeder::class,
            StockDataSeeder::class,
            StockSeeder::class,
        ]);
    }
}
