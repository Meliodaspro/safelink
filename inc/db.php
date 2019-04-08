<?php
ob_start();
// Cấu Hình Wap Site
$groupid = '135580577152514';
$url = 'http://hadpro.co';
$GoogleApiKey = 'AIzaSyBTIJVq8068Xj16yXT0Kcd7Ll81rl-w-lk';
$FacebookAppID = '1502586436493133';
$FacebookAppSecret = 'a52297aa0848b2575f59fc4e80f9d42e';

// Thông Tin MySql
$host = 'localhost:3306';
$user = 'hadproco_sql';
$pass = 'had07101994';
$data = 'hadproco_sql';
 
try {
    $db = new PDO("mysql:host=$host;dbname=$data", $user, $pass);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
ob_end_flush();
?>

