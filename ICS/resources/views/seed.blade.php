<!--
インベントリーシーダーテンプレ
DB::table('inventory')->insert([
    [
        'name' => '',
        'category_name' => '',
        'parchase' => '',
        'box_price' => '',
        'unit_price' => '',
        'lank' => '',
        'taste_flag' => '',
        'image_url' => '',
    ],
]);
-->

<!--
ストックシーダーテンプレ
DB::table('stock')->insert([
    [
        'inventories_id' => '',
        'expired_at' => '',
        'limited_at' => '',
        'stock' => '',
        'taste_name' => '',
    ],
]);
-->


@php

// インベントリ
/*
echo "DB::table('inventory')->insert([";

    $l = 1;
    for ($i = 1; $i <= 20; $i++) {

        if ($l == 6) {
            $l = 1;
        }

        $parcahse = $i * 10;
        $box_price = $l * 20000;
        $unit_price = floor($box_price / $parcahse);

        if ($unit_price >= 780) {
            $lank = "A";
        } elseif ($unit_price <= 779 and $unit_price >= 680) {
            $lank = "B";
        } elseif ($unit_price <= 679 and $unit_price >= 580) {
            $lank = "C";
        } elseif ($unit_price <= 579 and $unit_price >= 400) {
            $lank = "D";
        } elseif ($unit_price <= 399 and $unit_price >= 300) {
            $lank = "E";
        } elseif ($unit_price <= 299 and $unit_price >= 100) {
            $lank = "F";
        } else {
            $lank = "ランクなし";
        }

        if ($i % 2 != 0) {
            $taste_flag = "0";
            $image_url = "10101010";
        } else {
            $taste_flag = "1";
            $image_url = "";
        }

        echo "<br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp; [ <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'name' => '景品$i', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'category_name' => 'カテゴリ$l', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'parchase' => '$parcahse', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'box_price' => '$box_price', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'unit_price' => '$unit_price', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'lank' => '$lank', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'taste_flag' => '$taste_flag', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'image_url' => '$image_url', <br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;
            ],<br />";

        $l++;

    }
echo "]);<br />";
*/




// ストック

echo "DB::table('stock')->insert([";

    $l = 1;
    $m = 1;
    $longMonth = array(1, 3, 5, 7, 8, 10, 12);
    $shortMonth = array(4, 6, 9, 11);

    for ($i = 1; $i <= 60; $i++) {

        if ($l == 13) {
            $l = 1;
        }
        if ($m == 21) {
            $m = 1;
        }

        if (in_array($l, $longMonth)) {
            $day = '31';
        } elseif (in_array($l, $shortMonth)) {
            $day = '30';
        } else {
            $day = '28';
        }

        if ($l - 10 < 0) {
            $expired_at = '2023-0' . $l . '-' . $day;
        } else {
            $expierd_at = '2023' . $l . '-' . $day;
        }

        $limited_at = date('Y-m-d', strtotime("$expired_at -45 day"));
        $stock = $l * $m;

        if ($i % 2 != 0) {
            if (($i - 1) % 10 == 0) {
                $taste_name = "グレープ";
            } elseif (($i - 3) % 10 == 0) {
                $taste_name = "オレンジ";
            } elseif (($i - 5) % 10 == 0) {
                $taste_name = "メロン";
            } elseif (($i - 7) % 10 == 0) {
                $taste_name = "アップル";
            } else {
                $taste_name = "ストロベリー";
            }
        }

            echo "<br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp; [ <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'inventory_id' => '$m', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'expired_at' => '$expired_at', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'inventory_stock_id' => '@', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'limited_at' => '$limited_at', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'stock' => '$stock', <br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                'taste_name' => '$taste_name', <br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;],<br />";

            $l++;
            $m++;
    }
echo "]);";

@endphp
