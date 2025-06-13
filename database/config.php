<?php

require "../helpers.php";

$db = __DIR__ . '/bingo.sqlite';
try {
    $pdo = new PDO("sqlite:$db");
} catch (PDOException $e) {
    echo $e->getMessage();
    cerror('Connection failed: ' . $e->getMessage());
}