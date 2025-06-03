<?php
session_start();
require_once 'config.php';
require '../vendor/autoload.php'; // Add this line to include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM contact_submissions WHERE id = ?");
$stmt->execute([$_GET['id']]);
$submission = $stmt->fetch();

if (!$submission) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reply = $_POST['reply'];
    $to = $submission['email'];
    $subject = "Re: Your Contact Form Submission";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'siddheshgawade45s2@gmail.com';
        $mail->Password   = 'afkd ppiz eiav rdfb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('siddheshgawade45s2@gmail.com', 'Siddhu');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <html>
            <body>
                <h2>Thank you for contacting us!</h2>
                <p>Here's our response to your inquiry:</p>
                <p>" . nl2br(htmlspecialchars($reply)) . "</p>
                <p>Best regards,<br>Your Company Name</p>
            </body>
            </html>
        ";

        $mail->send();
        $stmt = $pdo->prepare("UPDATE contact_submissions SET is_replied = 'replied' WHERE id = ?");
        $stmt->execute([$submission['id']]);
        $success = "Reply sent successfully!";
    } catch (Exception $e) {
        $error = "Failed to send the reply. Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submission</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">View Submission</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-bold mb-4">Submission Details</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($submission['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($submission['email']); ?></p>
            <p><strong>Message:</strong></p>
            <p class="whitespace-pre-wrap"><?php echo htmlspecialchars($submission['message']); ?></p>
            <p><strong>Submitted at:</strong> <?php echo $submission['submitted_at']; ?></p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Reply to Submission</h2>
            <?php if (isset($success)): ?>
                <p class="text-green-500 mb-4"><?php echo $success; ?></p>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <p class="text-red-500 mb-4"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="reply" class="block text-gray-700 font-bold mb-2">Your Reply</label>
                    <textarea id="reply" name="reply" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="6"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Send Reply
                </button>
            </form>
        </div>
    </div>
</body>
</html>