<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    foreach ($images as $image) {
        $html .= '<div class="bg-white p-4 rounded shadow">';
        $html .= '<img src="../uploads/' . htmlspecialchars($image['filename']) . '" alt="' . htmlspecialchars($image['title']) . '" class="w-full h-48 object-cover mb-2">';
        $html .= '<h3 class="font-bold">' . htmlspecialchars($image['title']) . '</h3>';
        $html .= '<p class="text-sm text-gray-600">' . htmlspecialchars($image['description']) . '</p>';
        $html .= '<button onclick="deleteImage(' . $image['id'] . ')" class="mt-2 bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>';
        $html .= '</div>';
    }

    echo json_encode(['html' => $html]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error loading gallery images: ' . $e->getMessage()]);
}