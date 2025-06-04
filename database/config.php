<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

require "../helpers.php";

$db = __DIR__ . '/bingo.sqlite';
try {
    $pdo = new PDO("sqlite:$db");
    cinfo("Connected to database");
} catch (PDOException $e) {
    echo $e->getMessage();
    cerror('Connection failed: ' . $e->getMessage());
}