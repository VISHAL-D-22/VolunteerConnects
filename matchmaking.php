<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Matchmaking | VolunteerConnects</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<br><br>
        <a href='home.html' id='anchor' style='text-decoration:none;text-align:center'><h1 class='first'>Volunteer<span class='heads' style='color:green'>Connects</span></h1></a>
<div class="container py-5">
    <div class="glass-panel">
        <h2 class="fw-bold text-dark border-bottom pb-3 mb-4">Matching Engine Analysis</h2>
        <?php
        $event_id = $_GET['event_id'];
        $eventStmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
        $eventStmt->execute([$event_id]);
        $event = $eventStmt->fetch();

        $roleStmt = $pdo->prepare("SELECT * FROM event_roles WHERE event_id = ?");
        $roleStmt->execute([$event_id]);
        $roles = $roleStmt->fetchAll();

        foreach ($roles as $role): ?>
            <div class="card mb-4 border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white rounded-top-4">
                    <strong>Role:</strong> <?php echo $role['role_name']; ?> 
                    <span class="badge bg-info ms-2">Need: <?php echo $role['required_count']; ?></span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead><tr><th>Volunteer</th><th>Skill Match</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php
                            $matchStmt = $pdo->prepare("
                                SELECT v.volunteer_id, v.name, s.skill_name 
                                FROM volunteers v
                                JOIN volunteer_skills vs ON v.volunteer_id = vs.volunteer_id
                                JOIN skills s ON vs.skill_id = s.skill_id
                                WHERE s.skill_name LIKE ? 
                                AND v.volunteer_id NOT IN (SELECT volunteer_id FROM assignments WHERE role_id = ?)
                            ");
                            $matchStmt->execute(['%' . $role['role_name'] . '%', $role['role_id']]);
                            while($m = $matchStmt->fetch()): ?>
                            <tr>
                                <td><?php echo $m['name']; ?></td>
                                <td><span class="badge bg-success"><?php echo $m['skill_name']; ?></span></td>
                                <td>
                                    <form action="assign_volunteer.php" method="POST">
                                        <input type="hidden" name="role_id" value="<?php echo $role['role_id']; ?>">
                                        <input type="hidden" name="volunteer_id" value="<?php echo $m['volunteer_id']; ?>">
                                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                        <button class="btn btn-sm btn-primary rounded-pill">Assign</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>