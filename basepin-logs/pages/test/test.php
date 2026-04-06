<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Mobile App</title>
    <link rel="stylesheet" href="../../pages/test/test.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../component/navbar/nav.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body>

<?php include "../../component/navbar/nav.php" ?>

<div class="form-container">
    <div class="tabs">
        <div class="tab active" onclick="openTab('form')">Input Form</div>
        <div class="tab" onclick="openTab('logs')">View Logs</div>
    </div>

    <div class="container">
        <div id="form-section" class="content-view">
            <div class="box-card">
                <label>Name</label>
                <input type="text" placeholder="Enter name">
                
                <label>Message</label>
                <textarea placeholder="Details here..."></textarea>
                
                <button class="btn">Save Entry</button>
            </div>
        </div>

        <div id="logs-section" class="content-view hidden">
            <div class="box-card log-item">
                <div class="log-meta"><strong>Juan</strong> • 10:45 AM</div>
                <p>Checked inventory stocks.</p>
            </div>
            
            <div class="box-card log-item">
                <div class="log-meta"><strong>Maria</strong> • 09:12 AM</div>
                <p>System update completed.</p>
            </div>
        </div>
    </div>
</div>
    <script>
        function openTab(name) {
            const sections = document.querySelectorAll('.content-view');
            const tabs = document.querySelectorAll('.tab');
            
            sections.forEach(s => s.classList.add('hidden'));
            tabs.forEach(t => t.classList.remove('active'));

            document.getElementById(name + '-section').classList.remove('hidden');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>