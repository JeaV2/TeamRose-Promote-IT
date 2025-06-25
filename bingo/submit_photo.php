<?php
session_start();
require '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo']) && isset($_POST['task_id']) && in_array($_SERVER['HTTP_REFERER'], ['https://102710.stu.sd-lab.nl/promote-it-ohm/bingo/', 'https://102710.stu.sd-lab.nl/promote-it-ohm/bingo/index.php'])) {
    $userId = $_SESSION['user_id'] ?? null;
    $taskId = intval($_POST['task_id']);

    if (!$userId) {
        echo json_encode(['success' => false, 'message' => 'User niet gevonden']);
        exit;
    }

    //Maak directory voor foto's aan
    $uploadDir = '../uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['photo'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Onjuist bestandstype, geaccepteerde bestandstypen: ' . implode(', ', $allowedTypes)]);
        exit;
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Bestand is te groot, maximaal 5MB']);
        exit;
    }

    $fileName = $userId . '_' . $taskId . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        try {
            // Check if submission already exists
            $stmt = $pdo->prepare("SELECT id FROM task_submissions WHERE user_id = ? AND task_id = ?");
            $stmt->execute([$userId, $taskId]);

            if ($stmt->fetch()) {
                // Update existing submission
                //Normally should be unused because you can't send multiple photo's on the same task
                $stmt = $pdo->prepare("UPDATE task_submissions SET photo_path = ?, submitted_at = CURRENT_TIMESTAMP WHERE user_id = ? AND task_id = ?");
                $stmt->execute([$filePath, $userId, $taskId]);
            } else {
                // Create new submission
                $stmt = $pdo->prepare("INSERT INTO task_submissions (user_id, task_id, photo_path) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $taskId, $filePath]);
            }
            echo json_encode(['success' => true, 'message' => 'Foto succesvol geupload']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error:' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Upload gefaald']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Er is iets misgegaan, probeer het opnieuw.']);
}