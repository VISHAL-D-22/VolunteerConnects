<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard | VolunteerConnects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> 
    <style>
    body {
        /* Increased overlay opacity from 0.8 to 0.92 for much better clarity */
        background: linear-gradient(rgba(242, 245, 249, 0.92), rgba(242, 245, 249, 0.92)), 
                    url('volcon.png');
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-container {
        padding: 20px 0 40px;
    }

    /* SIDEBAR: Added a slight white glow to separate it from the background */
    .event-sidebar {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        padding: 25px;
        border: 1px solid #ffffff;
        height: 80vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    #event-list {
        flex-grow: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 8px;
    }

    /* CUSTOM SCROLLBAR: Makes the narrow sidebar look cleaner */
    #event-list::-webkit-scrollbar { width: 4px; }
    #event-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .event-item {
        background: #ffffff;
        border-radius: 15px;
        padding: 15px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.25s ease;
        border: 2px solid #f1f5f9;
    }

    .event-item:hover {
        transform: translateY(-3px);
        border-color: #4f46e5;
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.1);
    }

    .event-item.active {
        border-color: #008000;
        background: #f0fff4;
    }

    /* RESULTS PANEL: Near-solid white to block out background noise */
    .results-panel {
        background: #ffffff; 
        border-radius: 25px;
        padding: 35px;
        min-height: 80vh;
        box-shadow: 0 15px 45px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
    }

    .results-panel h3 { color: #0f172a; font-weight: 800; letter-spacing: -0.5px; }

    .volunteer-badge {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px;
        transition: 0.3s;
    }

    .volunteer-badge:hover {
        background: #ffffff;
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .status-dot {
        height: 10px; width: 10px;
        background-color: #22c55e;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
</style>
</head>
<body>

<div class="py-4 text-center">
    <a href="home.html" id="anchor" style="text-decoration: none;">
        <h1 class="first">Volunteer<span class="heads" style="color: green;">Connects</span></h1>
    </a>
    <!-- <p class="text-dark fw-bold"></p> -->
    <h5>Management Control Center</h5>
</div>

<div class="container dashboard-container">
    <div class="row g-4">
        
        <div class="col-lg-4 col-md-5">
            <div class="event-sidebar">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0 text-dark">Active Events</h5>
                    <a href="create_event.html" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">+ New</a>
                </div>
                
                <div class="mb-3">
                    <input type="text" id="eventSearch" class="form-control form-control-sm rounded-pill px-3 border-primary" 
                           placeholder="🔍 Search events..." onkeyup="filterEvents()">
                </div>
                
                <div id="event-list">
                    <?php
                    try {
                        $events = $pdo->query("SELECT * FROM events ORDER BY event_date ASC")->fetchAll();
                        foreach($events as $row): ?>
                            <div class="event-item" onclick="loadMatches(this, <?= $row['event_id'] ?>, 'Security')">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1 event-name text-dark"><?= htmlspecialchars($row['event_name']) ?></h6>
                                        <small class="text-muted">📅 <?= $row['event_date'] ?></small>
                                    </div>
                                    <span class="badge bg-light text-dark rounded-pill">ID: <?= $row['event_id'] ?></span>
                                </div>
                            </div>
                        <?php endforeach;
                    } catch(Exception $e) { echo "Error loading events."; }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <div class="results-panel">
                <div id="results-header" class="mb-4">
                    <h3 class="fw-bold">Smart Matching Engine</h3>
                    <p class="text-dark">Select an event from the left to filter volunteers by skill and availability.</p>
                </div>

                <div id="results-area" class="row g-3">
                    <div class="text-center py-5">
                        <div class="display-1 mb-3">🔍</div>
                        <p class="text-dark fw-bold">Select an event from the left to begin matching...</p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
function filterEvents() {
    const input = document.getElementById('eventSearch').value.toLowerCase();
    const eventItems = document.querySelectorAll('.event-item');
    eventItems.forEach(item => {
        const eventName = item.querySelector('.event-name').innerText.toLowerCase();
        item.style.display = eventName.includes(input) ? "block" : "none";
    });
}

async function loadMatches(element, eventId, role) {
    document.querySelectorAll('.event-item').forEach(el => el.classList.remove('active'));
    element.classList.add('active');

    const resultsArea = document.getElementById('results-area');
    resultsArea.innerHTML = `
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary mb-3"></div>
            <p class="text-dark fw-bold">Scanning for available ${role} experts...</p>
        </div>`;

    try {
        const response = await fetch(`get_matches.php?event_id=${eventId}&role=${role}`);
        const volunteers = await response.json();

        if (volunteers.length === 0) {
            resultsArea.innerHTML = `
                <div class="col-12 text-center py-5">
                    <p class="alert alert-warning rounded-pill">No volunteers found matching both skill and availability.</p>
                </div>`;
            return;
        }

        let html = '';
        volunteers.forEach(v => {
            html += `
                <div class="col-md-6">
                    <div class="volunteer-badge shadow-sm">
                        <div class="d-flex align-items-center mb-2">
                            <span class="status-dot"></span>
                            <h6 class="fw-bold m-0 text-dark">${v.name}</h6>
                        </div>
                        <p class="small text-muted mb-3">📧 ${v.email}<br>📞 ${v.phone}</p>
                        <button class="btn btn-success btn-sm w-100 rounded-pill">Confirm Assignment</button>
                    </div>
                </div>`;
        });
        resultsArea.innerHTML = html;
    } catch (err) {
        resultsArea.innerHTML = '<div class="alert alert-danger">Matching engine error. Check get_matches.php</div>';
    }
}
</script>

</body>
</html>