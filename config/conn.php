<?php
$host = 'localhost';
$dbname = 'bk_poliklinik';
$username = 'root';
$password = 'root';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
?>