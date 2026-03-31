<?php
$cols = [
        'section', 'control_number', 'technician_name',
        'date_of_verification'
    
    ];
$sql = "SELECT * FROM terminal_inspections 
          ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
 
if (!$result){
    die("Error");
}
?>