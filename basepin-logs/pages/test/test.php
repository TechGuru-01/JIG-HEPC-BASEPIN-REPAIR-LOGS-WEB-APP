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
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <?php foreach ($cols as $column): ?>
                    <td>
                        <?php 
                            // 1. Handling para sa Photos (View Button)
                            if (strpos($column, 'photo') !== false) {
                                if (!empty($row[$column])) {
                                    $imgPath = "../../src/uploads/" . $row[$column];
                                    echo "<button type='button' class='view-btn' onclick=\"openModal('$imgPath')\">
                                            <span class='material-icons-outlined' style='font-size:16px;'>image</span> View
                                          </button>";
                                } else {
                                    echo "<span class='no-photo'>No Image</span>";
                                }
                            } 
                            // 2. Handling para sa Status (Pills)
                            elseif (strpos($column, 'status') !== false) {
                                $status = strtolower($row[$column]);
                                $statusClass = ($status == 'ok') ? 'status-ok' : 'status-ng';
                                echo "<span class='status-pill $statusClass'>" . strtoupper($row[$column]) . "</span>";
                            }
                            // 3. Normal Text
                            else {
                                echo htmlspecialchars($row[$column] ?? ''); 
                            }
                        ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="27" style="text-align:center; padding: 20px;">Walang laman ang database, bitchass.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>
</div>
    </div>

    <div id="imageModal" class="modal">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="fullImage">
    <div id="caption"></div>

</div>
<script src="../../component/dashboardHeader/dashboardHeader.js"></script>
</body>
</html>