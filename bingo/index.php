<?php
global$pdo;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../database/config.php';

try {
    $query = "SELECT * FROM bingo_questions";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $resultaten = $stmt->fetchAll();
    $aantalRijen = count($resultaten);
    cinfo('Query executed.');
}
catch (PDOException $e) {
    cerror('a'.$e->getMessage());
}

cinfo('Loaded index');

include_once 'bingo_view.php';