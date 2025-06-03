<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    redirect('index.php');
}

if (isset($_GET['id'])) {
    $image_id = $_GET['id'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT filename FROM gallery_images WHERE id = ?");
        $stmt->execute([$image_id]);
        $image = $stmt->fetch();

        if ($image) {
            $file_path = "../uploads/" . $image['filename'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
            $stmt->execute([$image_id]);

            $pdo->commit();
            $_SESSION['error_message'] = "Image deleted successfully.";
        } else {
            throw new Exception("Image not found.");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['error_message'] = "Invalid request.";
}

header("Location: dashboard.php");