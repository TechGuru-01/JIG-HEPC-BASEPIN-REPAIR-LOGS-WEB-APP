<?php
require_once "../../include/config.php";
require_once "../../include/logFunction.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css  ">
    <link rel="stylesheet" href="../../component/navbar/nav.css  ">
    <link rel="stylesheet" href="./log.css  ">
    <link rel="stylesheet" href="../../component/dashboardHeader/dashboardHeader.css ">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
    <?php include '../../component/navbar/nav.php'?>
    <div class="logs-content">
        <?php include '../../component/dashboardHeader/dashboardHeader.php'?>
         <hr>
        <div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <?php 
                foreach($cols as $column): ?>
                    <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            </tbody>
    </table>
</div>
    </div>
<script src="../../component/dashboardHeader/dashboardHeader.js"></script>
</body>
</html>