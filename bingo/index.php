<?php
session_start();
global $pdo;

$vragenIds = [];

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../database/config.php';

try {
    // Get or create user
    $userId = getUserId();
    
    // Check if user already has assigned tasks
    $existingTasks = getUserTasks($userId);
    
    if (count($existingTasks) >= 16) {
        // User already has tasks assigned
        $vragenIds = array_column($existingTasks, 'task_id');
        cinfo('Using existing tasks for user');
    } else {
        // Assign new tasks
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
            
            // Save assigned tasks to database
            saveUserTasks($userId, $vragenIds);
        }
    }
    
    // Get task data for display
    $userTasksData = getUserTasksWithData($userId);
    
    cinfo('Query executed.');
}
catch (PDOException $e) {
    cerror('Error: '.$e->getMessage());
}

function getUserId() {
    global $pdo;
    
    if (!isset($_SESSION['user_id'])) {
        $sessionId = session_id();
        
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE session_id = ?");
        $stmt->execute([$sessionId]);
        $user = $stmt->fetch();
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
        } else {
            // Create new user
            $stmt = $pdo->prepare("INSERT INTO users (session_id) VALUES (?)");
            $stmt->execute([$sessionId]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
        }
    }
    
    return $_SESSION['user_id'];
}

function getUserTasks($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT task_id FROM user_tasks WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function saveUserTasks($userId, $taskIds) {
    global $pdo;
    
    foreach ($taskIds as $taskId) {
        $stmt = $pdo->prepare("INSERT INTO user_tasks (user_id, task_id) VALUES (?, ?)");
        $stmt->execute([$userId, $taskId]);
    }
}

function getUserTasksWithData($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT bt.*, ut.id as user_task_id, 
               ts.photo_path, ts.status, ts.submitted_at
        FROM user_tasks ut 
        JOIN bingo_tasks bt ON ut.task_id = bt.id 
        LEFT JOIN task_submissions ts ON ts.user_id = ut.user_id AND ts.task_id = ut.task_id
        WHERE ut.user_id = ?
        ORDER BY ut.id
    ");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

cinfo('Loaded index');

include_once 'bingo_view.php';