<?php
 /* 
 --------------------------------------
 -- Tên Code : Code Link Protect Facebook Page
 -- Người Coder : Hậu Nguyễn 
 -- Sử Dụng : PHP 7 & PDO 
 -- Vui Lòng Tôn Trọng Bản Quyền 
 --------------------------------------
 */
define('Hadpro', 1);
session_start();
unset($_SESSION["facebook_access_token"]);
header("Location: /index.php");
?>