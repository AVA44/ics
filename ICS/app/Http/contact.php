<?php
    $host = 'localhost';
    $dbname = 'ics';
    $dbuser = 'root';
    $dbpass = '44163264';

    try {
        $dbh = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $dbuser, $dbpass);
    } catch (PDOException $e) {
        var_dump('データベース接続失敗' . $e->getMessage());
        exit;
    }

    $stmt = $dbh->prepare("
            SELECT *
            FROM inventories
            WHERE 1 = 1
            AND name = :name
            AND category_name = :category_name
        ");


    if (isset($_POST['name_search'], $_POST['cate_search'])) {
        $stmt->bindparam(:name, $_POST['name_search'], PDO::PARAM_STR);
        $stmt->bindparam(:category_name, $_GET['cate_search'], PDO::PARAM_STR);

    } elseif (isset($_POST['name_search'])) {
        $stmt->bindparam(:name, $_POST['name_search'], PDO::PARAM_STR);
        $stmt->bindparam(:category_name, 'true', PDO::PARAM_BOOL);

    } elseif (isset($_POST['cate_search'])) {
        $stmt->bindparam(:name, 'true', PDO::PARAM_BOOL);
        $stmt->bindparam(:category_name, $_POST['cate_search'], PDO::PARAM_STR);

    } else {
        $stmt->bindparam(:name, 'true', PDO::PARAM_BOOL);
        $stmt->bindparam(:category_name, 'true', PDO::PARAM_BOOL);
    }

    $stmt->execute();


    $inventories_data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $inventories_data[] = array(
        'name' => $row['name'],
        'category_name' => $row['category_name']
        );
    }

    header('Content-type: application/json');
    echo  json_encode($inventries_data,JSON_UNESCAPED_UNICODE);
?>
