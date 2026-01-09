<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $role_names = $_POST['role_name']; 
    $required_counts = $_POST['required_count'];

    try {
        $pdo->beginTransaction();

        // 1. Insert the main Event
        $stmt = $pdo->prepare("INSERT INTO events (event_name, event_date, status) VALUES (?, ?, 'upcoming')");
        $stmt->execute([$event_name, $event_date]);
        $event_id = $pdo->lastInsertId();

        // 2. Insert the specific roles
        $roleStmt = $pdo->prepare("INSERT INTO event_roles (event_id, role_name, required_count) VALUES (?, ?, ?)");
        
        for ($i = 0; $i < count($role_names); $i++) {
            if (!empty($role_names[$i])) {
                $roleStmt->execute([$event_id, $role_names[$i], $required_counts[$i]]);
            }
        }

        $pdo->commit();

        // DISPLAY THE BEAUTIFUL GLASS PANEL SUCCESS PAGE
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>Success | VolunteerConnects</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <link rel='stylesheet' href='style.css'>
            <style>
                .success-icon {
                    font-size: 5rem;
                    color: #2ec4b6;
                    animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                }
                @keyframes scaleIn {
                    from { transform: scale(0); opacity: 0; }
                    to { transform: scale(1); opacity: 1; }
                }
            </style>
        </head>
        <body>
        <br><br>
        <a href='home.html' id='anchor' style='text-decoration:none;text-align:center'><h1 class='first'>Volunteer<span class='heads' style='color:green'>Connects</span></h1></a>
            <div class='container d-flex justify-content-center align-items-center' style='min-height: 100vh;'>
                <div class='glass-panel text-center' style='max-width: 600px; width: 100%;'>
                    <div class='success-icon mb-3'>🎉</div>
                    <h1 class='fw-bold text-dark mb-2'>Event Created Successfully!</h1>
                    <p class='text-muted mb-4'>Your event <strong>" . htmlspecialchars($event_name) . "</strong> is now live. The matching engine is ready.</p>
                    
                    <div class='d-grid gap-2'>
                        <a href='matchmaking.php?event_id=$event_id' class='btn btn-success btn-lg rounded-pill shadow-sm py-3 fw-bold'>
                            Open Matchmaking Dashboard
                        </a>
                        <a href='home.html' class='btn btn-outline-secondary rounded-pill'>
                            Return to Home
                        </a>
                    </div>
                </div>
            </div>
        </body>
        </html>";

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}
?>