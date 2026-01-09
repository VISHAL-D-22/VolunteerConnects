<?php
require 'db.php'; // Connects to 'volunteer_system'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name     = $_POST['name'];
    $dob      = $_POST['dob'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $skills   = isset($_POST['skills']) ? $_POST['skills'] : [];

    try {
        $pdo->beginTransaction();

        // SQL Query matching your 6-column structure (ID, Name, DOB, Phone, Email, Password)
        $stmt = $pdo->prepare("INSERT INTO volunteers (name, dob, phone, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $dob, $phone, $email, $password]);
        
        $volunteer_id = $pdo->lastInsertId();
        // Add this inside the try block after $volunteer_id = $pdo->lastInsertId();
if (!empty($_POST['avail_date'])) {
    $availStmt = $pdo->prepare("INSERT INTO volunteer_availability (volunteer_id, busy_date) VALUES (?, ?)");
    // Note: If this is 'available date', you might need to invert your logic in get_matches.php
    $availStmt->execute([$volunteer_id, $_POST['avail_date']]);
}

        // Skill mapping for the matching engine
        if(!empty($skills)){
            $skillStmt = $pdo->prepare("INSERT INTO volunteer_skills (volunteer_id, skill_id) VALUES (?, ?)");
            foreach ($skills as $skill_id) {
                $skillStmt->execute([$volunteer_id, $skill_id]);
            }
        }

        $pdo->commit();

        // BEAUTIFUL SUCCESS UI
        // BEAUTIFUL SUCCESS UI
// ... [Your existing PHP logic for database insertion above] ...

// BEAUTIFUL SUCCESS UI
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Registration Complete | VolunteerConnects</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <style>
        /* FIX BACKGROUND COLLISION */
        body {
            background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)), url('volcon.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* HEADER STYLING */
        .header-top {
            padding: 40px 0 20px;
            text-align: center;
        }
        h1.first {
            color: #0000FF; /* Pure Blue */
            font-family: 'Lucida Sans', Geneva, Verdana, sans-serif;
            font-weight: bold;
            margin: 0;
        }
        .heads {
            color: #008000; /* Green */
        }

        /* PERFECT CENTERING FOR CARD */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* GLASS CARD STYLING */
        .registration-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .check-icon {
            width: 60px;
            height: 60px;
            background: #4ade80;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 20px;
        }

        .email-display {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            margin: 20px 0;
        }

        .btn-dashboard {
            background: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
        }

        .btn-dashboard:hover {
            background: #4338ca;
            transform: scale(1.02);
        }
    </style>
</head>
<body>

    <div class='header-top'>
        <a href='home.html' id='anchor' style='text-decoration:none;'>
            <h1 class='first'>Volunteer<span class='heads'>Connects</span></h1>
        </a>
    </div>

    <div class='main-container'>
        <div class='registration-card'>
            <div class='check-icon'>✓</div>
            <h2 class='fw-bold' style='color: #1e293b;'>Registration Complete!</h2>
            <p class='text-muted'>Welcome to the team, <strong>" . htmlspecialchars($name) . "</strong>. Your profile is now live in our matching engine.</p>
            
            <div class='email-display'>
                <span style='font-size: 12px; color: #64748b;'>Registered Email</span><br>
                <strong style='color: #0f172a;'>" . htmlspecialchars($email) . "</strong>
            </div>

            <a href='home.html' class='btn-dashboard'>Sign In to Dashboard</a>
        </div>
    </div>

</body>
</html>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div style='color: white; background: red; padding: 20px;'>Error: " . $e->getMessage() . "</div>";
    }
}
?>