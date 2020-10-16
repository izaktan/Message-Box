<?php
    require __DIR__ . 'YOUR_SERVER_PASS.php';

    $data = json_decode(file_get_contents("php://input"));

    $input = $data->input;
    $id = $data->id;
    
    $connection = mysqli_connect($host, $user, $pass, $db) or die("Unable to connect!"); 
    $input = mysqli_real_escape_string($connection,$input);
    mysqli_set_charset($connection,"utf8mb4");
	date_default_timezone_set("Asia/Shanghai");
    $time = date("Y-m-d h:i:sa");

    $read_replies = "SELECT `id`, `replies` FROM `TABLE_NAME` WHERE id=".$id;
    $result = mysqli_query($connection, $read_replies) or die(mysqli_error());
    $row = mysqli_fetch_assoc($result);
    print_r($row);
    $id = $row['id'];
    $replies = $row['replies'];

    $replies = json_decode($replies, JSON_UNESCAPED_UNICODE);
    $replies[] = array(
        "time" => $time,
        "reply" => $input,
    );
    $replies = json_encode($replies, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);
    $write_new = "UPDATE `TABLE_NAME` SET replies='".$replies."' WHERE id=".$id;
    mysqli_query($connection, $write_new);
	$connection->close(); 