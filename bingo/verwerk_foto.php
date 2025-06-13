<?php
session_start();
require '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo']) && isset($_POST['task_id'])) {
    $userId = $_SESSION['user_id'] ?? null;
    $taskId = intval($_POST['task_id']);

    if (!$userId) {
        echo json_encode(['success' => false, 'message' => 'Geen user gevonden']);
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
        echo json_encode(['success' => false, 'message' => 'Ongeldig bestandstype, alleen jpeg, png en gif zijn toegestaan.']);
        exit;
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Bestand is te groot, hou het kleiner dan 5MB.']);;
        exit;
    }

    $fileName = $userId . '_' . $taskId . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM task_submissions WHERE user_id = ? AND task_id = ?");
            $stmt->execute([$userId, $taskId]);
            if ($stmt->fetch()) {
                $stmt = $pdo->prepare("UPDATE task_submissions SET photo_path = ?, submitted_at = CURRENT_TIMESTAMP WHERE user_id = ? AND task_id = ?");
                $stmt->execute([$filePath, $userId, $taskId]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO task_submissions (user_id, task_id, photo_path) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $taskId, $filePath]);
            }
            echo json_encode(['success' => true, 'message' => 'Foto succesvol verwerkt']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Fout bij verwerken van foto: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Fout bij uploaden van foto']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geen foto gevonden/Verkeerde request']);
}