<?php
require_once "../../include/config.php";
require_once '../../include/auth_checker.php'; 


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css  ">
    <link rel="stylesheet" href="../../component/navbar/nav.css  ">
    <link rel="stylesheet" href="./dashboard.css  ">
    <link rel="stylesheet" href="../../component/dashboardHeader/dashboardHeader.css  ">
    <link rel="stylesheet" href="../../component/Forms/dashboardForm.css  ">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
    <?php include '../../component/navbar/nav.php'?>
    <div class="dashboard-content">
        <?php include "../../component/dashboardHeader/dashboardHeader.php"?>
        <hr>
        <?php include "../../component/Forms/dashboardForm.php"?>
    </div>
<script src="../../component/Forms/dashboardForm.js"></script>
<script src="../../component/dashboardHeader/dashboardHeader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="dashboard.js"></script>
<script src="../../component/navbar/nav.js"></script>
</body>
</html>