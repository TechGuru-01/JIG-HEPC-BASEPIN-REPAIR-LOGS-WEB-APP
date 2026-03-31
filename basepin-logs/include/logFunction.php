<?php
$query = "SELECT i.*, r.part_no, r.reason, r.date_replaced, r.rep_technician, r.cp_control_no 
          FROM inspections i 
          LEFT JOIN replacement_details r ON i.id = r.inspection_id 
          ORDER BY i.created_at DESC";
$result = mysqli_query($conn, $query);
?>