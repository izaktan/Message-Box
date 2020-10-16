<?php
    require __DIR__ . 'YOUR_SERVER_PASS.php';


// if($_SERVER['HTTP_REFERER'] == $fromUrl) {
    $connection = mysqli_connect($host, $user, $pass, $db) or die("Unable to connect!");
    mysqli_set_charset($connection,"utf8mb4");
    $select = "SELECT * FROM `TABLE_NAME`";
    $result = mysqli_query($connection, $select) or die(mysqli_error());

    $index = 0;
    while($row = $result->fetch_assoc()) {
        $row["real_index"] = $index;
        $row['replies'] = json_decode($row['replies']);
        array_splice($row, 4, -1);
//        array_splice($row, 2, 0, array("real_index" => $index));
        $array[] = $row;
        $index++;
    //$array[] = $row;
    };
//    $array = array_reverse($array);
    $json_data = json_encode($array, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);
    echo $json_data;