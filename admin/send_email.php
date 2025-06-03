<?php
require_once 'config.php';

function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . "Send Email Error: " . $message . "\n", 3, 'error.log');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['email'])) {
    $id = $_POST['id'];
    $reply = $_POST['email'];

    try {
        // Get the submission details
        $stmt = $pdo->prepare("SELECT * FROM contact_submissions WHERE id = ?");
        $stmt->execute([$id]);
        $submission = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($submission) {
            $to = $submission['email'];
            $subject = "Re: Your message to Travel Website";
            $message = "Dear " . $submission['name'] . ",\n\n";
            $message .= "Thank you for contacting us. Here's our reply:\n\n";
            $message .= $reply . "\n\n";
            $message .= "Best regards,\nTravel Website Team";
            $headers = "From: noreply@travelwebsite.com";

            // Use PHP's mail function to send the email
            if (mail($to, $subject, $message, $headers)) {
                // Update the submission status
                $stmt = $pdo->prepare("UPDATE contact_submissions SET is_replied = TRUE WHERE id = ?");
                $stmt->execute([$id]);

                echo json_encode(['success' => 'Email sent successfully!']);
            } else {
                throw new Exception("Failed to send email.");
            }
        } else {
            throw new Exception("Submission not found.");
        }
    } catch (Exception $e) {
        logError($e->getMessage());
        echo json_encode(['error' => 'Error sending email: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}