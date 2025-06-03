<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    redirect('index.php');
}

// Fetch gallery images
$stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
$gallery_images = $stmt->fetchAll();

// Fetch contact submissions
$stmt = $pdo->query("SELECT * FROM contact_submissions ORDER BY submitted_at DESC");
$contact_submissions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmstay Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-800">Farmstay Admin</h1>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">Logout</a>
                </div>
            </div>
        </header>

        <main class="flex-grow container mx-auto px-4 py-8">
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['success_message']; ?></span>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['error_message']; ?></span>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Gallery Management</h2>
                    <a href="upload_image.php" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-600 transition duration-300 mb-4 inline-block">Upload New Image</a>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($gallery_images as $image): ?>
                            <div class="relative group">
                                <img src="../uploads/<?php echo htmlspecialchars($image['filename']); ?>" alt="<?php echo htmlspecialchars($image['title']); ?>" class="w-full h-32 object-cover rounded-md">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                    <a href="delete_image.php?id=<?php echo $image['id']; ?>" class="text-white bg-red-500 px-3 py-1 rounded-md hover:bg-red-600 transition duration-300">Delete</a>
                                </div>
                                <p class="mt-2 text-sm text-gray-600"><?php echo htmlspecialchars($image['title']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Contact Submissions</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="text-left py-2 px-3">Name</th>
                                    <th class="text-left py-2 px-3">Email</th>
                                    <th class="text-left py-2 px-3">Message</th>
                                    <th class="text-left py-2 px-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contact_submissions as $submission): ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-3"><?php echo htmlspecialchars($submission['name']); ?></td>
                                        <td class="py-2 px-3"><?php echo htmlspecialchars($submission['email']); ?></td>
                                        <td class="py-2 px-3"><?php echo ucfirst($submission['message']); ?></td>
                                        <td class="py-2 px-3">
                                            <a href="view_submission.php?id=<?php echo $submission['id']; ?>" class="text-blue-500 hover:underline">View</a>
                                            <a href="delete_submission.php?id=<?php echo $submission['id']; ?>" class="text-red-500 hover:underline ml-2">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Analytics</h2>
                <canvas id="submissionsChart"></canvas>
            </div>
        </main>

        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto px-4 text-center">
                &copy; 2023 Farmstay Admin. All rights reserved.
            </div>
        </footer>
    </div>

</body>
</html>