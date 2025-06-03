<?php
require_once 'config.php';

function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . "Contact Submissions Error: " . $message . "\n", 3, 'error.log');
}

try {
    $stmt = $pdo->query("SELECT * FROM contact_submissions ORDER BY submitted_at DESC");
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    foreach ($submissions as $submission) {
        $html .= '<tr>';
        $html .= '<td class="py-3 px-6 text-left">' . htmlspecialchars($submission['name']) . '</td>';
        $html .= '<td class="py-3 px-6 text-left">' . htmlspecialchars($submission['email']) . '</td>';
        $html .= '<td class="py-3 px-6 text-left">' . htmlspecialchars($submission['message']) . '</td>';
        $html .= '<td class="py-3 px-6 text-center">';
        $html .= '<button onclick="sendEmail(' . $submission['id'] . ')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 mr-2">Reply</button>';
        $html .= '<button onclick="deleteSubmission(' . $submission['id'] . ')" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>';
        $html .= '</td>';
        $html .= '</tr>';
    }

    echo json_encode(['html' => $html]);
} catch (PDOException $e) {
    logError($e->getMessage());
    echo json_encode(['error' => 'Error loading contact submissions: ' . $e->getMessage()]);
}