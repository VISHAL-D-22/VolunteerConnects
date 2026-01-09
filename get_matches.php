<?php
require 'db.php'; //

$event_id = $_GET['event_id'];
$role_name = $_GET['role'];

try {
    // 1. Get the event date first
    $stmtDate = $pdo->prepare("SELECT event_date FROM events WHERE event_id = ?");
    $stmtDate->execute([$event_id]);
    $event = $stmtDate->fetch();
    $date = $event['event_date'];

    // 2. SMART QUERY: Join skills and check availability
    // Find volunteers with the role name in their skills who are NOT busy on this date
    // Update the SQL in get_matches.php to check assignments too
$sql = "SELECT v.volunteer_id, v.name, v.email, v.phone 
        FROM volunteers v
        JOIN volunteer_skills vs ON v.volunteer_id = vs.volunteer_id
        JOIN skills s ON vs.skill_id = s.skill_id
        WHERE s.skill_name LIKE ? 
        AND v.volunteer_id NOT IN (
            SELECT volunteer_id FROM volunteer_availability WHERE busy_date = ?
        )
        AND v.volunteer_id NOT IN (
            SELECT a.volunteer_id FROM assignments a 
            JOIN event_roles er ON a.role_id = er.role_id
            JOIN events e ON er.event_id = e.event_id
            WHERE e.event_date = ?
        )";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$role_name%", $date, $date]); // Check both busy dates and existing event assignments
    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return as JSON for AJAX to read
    header('Content-Type: application/json');
    echo json_encode($matches);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>