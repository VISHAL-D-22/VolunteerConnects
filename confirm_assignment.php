<?php
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("UPDATE assignments SET status = 'confirmed' WHERE assignment_id = ?");
    $stmt->execute([$_POST['assignment_id']]);
    // Redirect back to dashboard with the same ID
    header("Location: volunteer_dashboard.php?id=" . $_POST['volunteer_id']);
}
?>