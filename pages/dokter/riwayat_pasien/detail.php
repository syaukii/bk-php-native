<?php
include_once '../../../config/conn.php';
session_start();

$url = "$_SERVER[REQUEST_URI]";
$urlParts = explode('/', $url);
$get_id = end($urlParts);



?>