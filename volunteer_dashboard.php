<?php
session_start();
// Replace $vol_id = $_GET['id']; with:
if (!isset($_SESSION['volunteer_id'])) {
    header("Location: home.html");
    exit();
}
$volunteer_id = $_SESSION['volunteer_id'];
require 'db.php'; 
$volunteer_id = isset($_GET['id']) ? $_GET['id'] : die("Volunteer ID required.");

// Fetch volunteer's name
$stmtV = $pdo->prepare("SELECT name FROM volunteers WHERE volunteer_id = ?");
$stmtV->execute([$volunteer_id]);
$volunteer = $stmtV->fetch();

// Fetch assignments with relational JOINs
$stmtA = $pdo->prepare("
    SELECT a.assignment_id, e.event_name, e.event_date, r.role_name, a.status 
    FROM assignments a
    JOIN event_roles r ON a.role_id = r.role_id
    JOIN events e ON r.event_id = e.event_id
    WHERE a.volunteer_id = ?
");
$stmtA->execute([$volunteer_id]);
$assignments = $stmtA->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer Dashboard | Connects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="style.css">
    <style>
        :root { --primary-blue: #007bff; --success-green: #28a745; }
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Animation for cards loading in */
        .assignment-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .assignment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }

        /* Status Badge Styling */
        .status-pill {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 15px;
            border-radius: 50px;
            text-transform: uppercase;
        }
        .bg-pending { background-color: #fff3cd; color: #856404; }
        .bg-confirmed { background-color: #d1e7dd; color: #0f5132; }

        .sidebar-profile {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <header class="text-center mb-5 animate__animated animate__fadeInDown">
        <br>
        <a href="home.html" id="anchor" style="text-decoration: none;"><h1 class="first">Volunteer<span class="heads" style="color: green;">Connects</span></h1></a>
        <big><em><p class="text-muted">Empowering communities through intelligent matchmaking.</p></em></big>
    </header>

    <div class="row g-4">
        <div class="col-lg-4 animate__animated animate__fadeInLeft">
            <div class="card sidebar-profile p-4 shadow text-center">
                <div class="rounded-circle bg-white text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <h2 class="m-0"><?php echo strtoupper(substr($volunteer['name'], 0, 1)); ?></h2>
                </div>
                <h4 class="mb-1"><?php echo htmlspecialchars($volunteer['name']); ?></h4>
                <p class="opacity-75 small">Volunteer ID: #<?php echo $volunteer_id; ?></p>
                <hr class="border-white opacity-25">
                <div class="text-start">
                    <p class="small mb-1"><strong>Status:</strong> Active Helper</p>
                    <p class="small"><strong>Matching:</strong> Online</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8 animate__animated animate__fadeInRight">
            <h5 class="fw-bold mb-4">Current Assignments</h5>
            
            <?php if (empty($assignments)): ?>
                <div class="card p-5 text-center shadow-sm border-0 rounded-4">
                    <p class="text-muted mb-0">The matching engine is currently finding events for you. Check back soon!</p>
                </div>
            <?php else: ?>
                <?php foreach ($assignments as $asgn): ?>
                    <div class="card assignment-card mb-3 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1"><?php echo $asgn['event_name']; ?></h5>
                                    <p class="text-muted mb-3"><i class="bi bi-calendar-event"></i> Date: <?php echo $asgn['event_date']; ?></p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary me-2">Role: <?php echo $asgn['role_name']; ?></span>
                                        <span class="status-pill <?php echo $asgn['status'] == 'confirmed' ? 'bg-confirmed' : 'bg-pending'; ?>">
                                            <?php echo $asgn['status']; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <?php if ($asgn['status'] == 'assigned'): ?>
                                    <form action="confirm_assignment.php" method="POST" class="animate__animated animate__pulse animate__infinite">
                                        <input type="hidden" name="assignment_id" value="<?php echo $asgn['assignment_id']; ?>">
                                        <input type="hidden" name="volunteer_id" value="<?php echo $volunteer_id; ?>">
                                        <button type="submit" class="btn btn-success fw-bold px-4 rounded-pill shadow-sm">Confirm Now</button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-outline-success btn-sm rounded-pill disabled">✓ Confirmed</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>