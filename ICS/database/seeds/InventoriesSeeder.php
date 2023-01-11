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
        DB::table('inventories')->insert([
            [
                'name' => '景品1',
                'category_name' => 'カテゴリ1',
                'parchase' => '10',
                'box_price' => '20000',
                'unit_price' => '2000',
                'lank' => 'A',

                'image_url' => '10101010',
            ],
            [
                'name' => '景品2',
                'category_name' => 'カテゴリ2',
                'parchase' => '20',
                'box_price' => '40000',
                'unit_price' => '2000',
                'lank' => 'A',

                'image_url' => '',
            ],
            [
                'name' => '景品3',
                'category_name' => 'カテゴリ3',
                'parchase' => '30',
                'box_price' => '60000',
                'unit_price' => '2000',
                'lank' => 'A',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品4',
                'category_name' => 'カテゴリ4',
                'parchase' => '40',
                'box_price' => '80000',
                'unit_price' => '2000',
                'lank' => 'A',

                'image_url' => '',
            ],
            [
                'name' => '景品5',
                'category_name' => 'カテゴリ5',
                'parchase' => '50',
                'box_price' => '100000',
                'unit_price' => '2000',
                'lank' => 'A',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品6',
                'category_name' => 'カテゴリ1',
                'parchase' => '60',
                'box_price' => '20000',
                'unit_price' => '333',
                'lank' => 'E',
                'image_url' => '',
            ],
            [
                'name' => '景品7',
                'category_name' => 'カテゴリ2',
                'parchase' => '70',
                'box_price' => '40000',
                'unit_price' => '571',
                'lank' => 'D',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品8',
                'category_name' => 'カテゴリ3',
                'parchase' => '80',
                'box_price' => '60000',
                'unit_price' => '750',
                'lank' => 'B',
                'image_url' => '',
            ],
            [
                'name' => '景品9',
                'category_name' => 'カテゴリ4',
                'parchase' => '90',
                'box_price' => '80000',
                'unit_price' => '888',
                'lank' => 'A',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品10',
                'category_name' => 'カテゴリ5',
                'parchase' => '100',
                'box_price' => '100000',
                'unit_price' => '1000',
                'lank' => 'A',
                'image_url' => '',
            ],
            [
                'name' => '景品11',
                'category_name' => 'カテゴリ1',
                'parchase' => '110',
                'box_price' => '20000',
                'unit_price' => '181',
                'lank' => 'F',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品12',
                'category_name' => 'カテゴリ2',
                'parchase' => '120',
                'box_price' => '40000',
                'unit_price' => '333',
                'lank' => 'E',
                'image_url' => '',
            ],
            [
                'name' => '景品13',
                'category_name' => 'カテゴリ3',
                'parchase' => '130',
                'box_price' => '60000',
                'unit_price' => '461',
                'lank' => 'D',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品14',
                'category_name' => 'カテゴリ4',
                'parchase' => '140',
                'box_price' => '80000',
                'unit_price' => '571',
                'lank' => 'D',
                'image_url' => '',
            ],
            [
                'name' => '景品15',
                'category_name' => 'カテゴリ5',
                'parchase' => '150',
                'box_price' => '100000',
                'unit_price' => '666',
                'lank' => 'C',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品16',
                'category_name' => 'カテゴリ1',
                'parchase' => '160',
                'box_price' => '20000',
                'unit_price' => '125',
                'lank' => 'F',
                'image_url' => '',
            ],
            [
                'name' => '景品17',
                'category_name' => 'カテゴリ2',
                'parchase' => '170',
                'box_price' => '40000',
                'unit_price' => '235',
                'lank' => 'F',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品18',
                'category_name' => 'カテゴリ3',
                'parchase' => '180',
                'box_price' => '60000',
                'unit_price' => '333',
                'lank' => 'E',
                'image_url' => '',
            ],
            [
                'name' => '景品19',
                'category_name' => 'カテゴリ4',
                'parchase' => '190',
                'box_price' => '80000',
                'unit_price' => '421',
                'lank' => 'D',
                'image_url' => '10101010',
            ],
            [
                'name' => '景品20',
                'category_name' => 'カテゴリ5',
                'parchase' => '200',
                'box_price' => '100000',
                'unit_price' => '500',
                'lank' => 'D',
                'image_url' => '',
            ],
        ]);
    }
}
