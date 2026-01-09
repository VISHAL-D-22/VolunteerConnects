<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role_id = $_POST['role_id'];
    $volunteer_id = $_POST['volunteer_id'];
    $event_id = $_POST['event_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO assignments (role_id, volunteer_id, status) VALUES (?, ?, 'assigned')");
        $stmt->execute([$role_id, $volunteer_id]);
        
        header("Location: matchmaking.php?event_id=$event_id&msg=assigned");
    } catch (Exception $e) {
        die("Error: This volunteer might already be assigned to this role.");
    }
}
?>