<?php
require_once "../../include/config.php";
require_once "../../include/logFunction.php";
require_once "../../include/auth_checker.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../component/navbar/nav.css">
    <link rel="stylesheet" href="./log.css">
    <link rel="stylesheet" href="../../component/dashboardHeader/dashboardHeader.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <title>Dashboard | Logs</title>
</head>
<body>
    <?php include '../../component/navbar/nav.php'?>

    <div class="logs-content">
        <?php include '../../component/dashboardHeader/dashboardHeader.php'?>
        <hr>

        <div class="header-action">
            <div class="action-container1">
                <span class="filter-label">Filter Logs</span>
            </div>

            <div class="action-container2">
                <div class="date-filter">
                    <div class="input-group">
                        <span class="material-icons-outlined">event</span>
                        <input type="date" id="dateFrom" title="Start Date">
                    </div>
                    
                    <div class="date-separator">to</div>
                    
                    <div class="input-group">
                        <span class="material-icons-outlined">event</span>
                        <input type="date" id="dateTo" title="End Date">
                    </div>
                </div>

                <div class="search-box">
                    <span class="material-icons-outlined">search</span>
                    <input type="text" id="mainSearch" placeholder="Search control number...">
                </div>

                <button type="button" class="excel-btn" onclick ="triggerExport()">
                    <span class="material-icons-outlined">description</span>
                    <span>EXPORT</span>
                </button>
            </div>
        </div>

       <?php include '../../component/logsTableHandler/logsTableHandler.php'?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../component/dashboardHeader/dashboardHeader.js"></script>
    <script src="../../component/logsTableHandler/deleteResponseHandler.js"></script>
    <script src="./log.js"></script>
</body>
</html>