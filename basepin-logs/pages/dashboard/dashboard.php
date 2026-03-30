<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css  ">
    <link rel="stylesheet" href="../../component/navbar/nav.css  ">
    <link rel="stylesheet" href="./dashboard.css  ">
    <link rel="stylesheet" href="../../component/dashboardHeader/dashboardHeader.css  ">
    <link rel="stylesheet" href="../../component/dashboardForm/dashboardForm.css  ">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
    <?php include '../../component/navbar/nav.php'?>
    <div class="dashboard-content">
        <?php include "../../component/dashboardHeader/dashboardHeader.php"?>
        <hr>
        <?php include "../../component/dashboardForm/dashboardForm.php"?>
    </div>
<script src="../../component/dashboardForm/dashboardForm.js"></script>
<script src="../../component/dashboardHeader/dashboardHeader.js"></script>
<script>
    const replaceYes = document.getElementById('replace_yes');
    const replaceNo = document.getElementById('replace_no');
    const subForm = document.getElementById('replacement-details');
    const subInputs = subForm.querySelectorAll('input');

    function toggleSubForm() {
        if (replaceYes.checked) {
            subForm.style.display = 'block';
            subInputs.forEach(input => input.required = true);
        } else {
            subForm.style.display = 'none';
            subInputs.forEach(input => {
                input.required = false;
                input.value = "";
            });
        }
    }

    replaceYes.addEventListener('change', toggleSubForm);
    replaceNo.addEventListener('change', toggleSubForm);
</script>
</body>
</html>