<?php
require_once "../../include/config.php";
require_once "../../include/logFunction.php";
// Make sure $cols and $result are defined in logFunction.php
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

                <button type="button" class="excel-btn">
                    <span class="material-icons-outlined">description</span>
                    <span>EXPORT</span>
                </button>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <?php foreach($cols as $column): ?>
                            <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                        <?php endforeach; ?>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <?php foreach($cols as $col): ?>
                                    <td><?= isset($row[$col]) ? htmlspecialchars($row[$col]) : 'N/A'; ?></td>
                                <?php endforeach; ?>
                                
                                <td class="action-column"> 
                                    <div class="action-buttons">
                                        <button class="sel_btn" name="sel_btn">Select</button>
                                        <button class="btn-view" title="View Details">
                                            <span class="material-icons-outlined">visibility</span>
                                        </button>
                                       
                                        <button class="btn-delete" title="Delete Record">
                                            <span class="material-icons-outlined">delete</span>
                                        </button>
                                        
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= count($cols) + 1; ?>" class="no-data">No logs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../component/dashboardHeader/dashboardHeader.js"></script>
</body>
</html>