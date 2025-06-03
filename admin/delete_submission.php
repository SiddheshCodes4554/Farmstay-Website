<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    redirect('index.php');
}

if (isset($_GET['id'])) {
    $submission_id = $_GET['id'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("DELETE FROM contact_submissions WHERE id = ?");
        $stmt->execute([$submission_id]);

        if ($stmt->rowCount() > 0) {
            $pdo->commit();
            $_SESSION['success_message'] = "Submission deleted successfully.";
        } else {
            throw new Exception("Submission not found or already deleted.");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['error_message'] = "Invalid request.";
}

header("Location: dashboard.php");