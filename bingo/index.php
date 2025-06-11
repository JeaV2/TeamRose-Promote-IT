<?php
global $pdo;

$vragenIds = [];

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../database/config.php';

try {
    $query = "SELECT * FROM bingo_tasks";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $resultaten = $stmt->fetchAll();
    $aantalRijen = count($resultaten);

    // Random nummer generator voor de vragen.
    if ($aantalRijen >= 16) {
        $randomNumbers = range(1, $aantalRijen - 1);
        shuffle($randomNumbers);
        $vragenIds = array_slice($randomNumbers, 0, 16);
    }

    cinfo('Query executed.');
}
catch (PDOException $e) {
    cerror('a'.$e->getMessage());
}

cinfo('Loaded index');

include_once 'bingo_view.php';