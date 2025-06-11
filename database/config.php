<?php

require "../helpers.php";

$db = __DIR__ . '/bingo.sqlite';
try {
    $pdo = new PDO("sqlite:$db");
    cinfo("Connected to database");
} catch (PDOException $e) {
    echo $e->getMessage();
    cerror('Connection failed: ' . $e->getMessage());
}