<?php
    require __DIR__ . 'YOUR_SERVER_PASS.php';

    $data = json_decode(file_get_contents("php://input"));

    $input = $data->input;
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $connection = mysqli_connect($host, $user, $pass, $db) or die("Unable to connect!"); 
    $input = mysqli_real_escape_string($connection,$input);
    mysqli_set_charset($connection,"utf8mb4");
	date_default_timezone_set("Asia/Shanghai");
    $time = date("Y-m-d h:i:sa");

    $row_number = "SELECT MAX(id) FROM `TABLE_NAME`";
    $result = mysqli_query($connection, $row_number) or die(mysqli_error());
    $row = mysqli_fetch_array($result);
    $id = $row[0]+1;
    $sql = "INSERT INTO TABLE_NAME
	(`id`, `time`, `content`, `replies`, `ip`) 
	VALUES
    ($id, '$time', '$input', '', '$ip')";
	mysqli_query($connection, $sql);
	$connection->close(); 