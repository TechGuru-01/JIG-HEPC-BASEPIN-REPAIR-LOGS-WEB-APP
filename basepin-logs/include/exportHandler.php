<?php

require_once './config.php'; 

if (isset($_GET['ids']) && !empty($_GET['ids'])) {
    $id_array = explode(',', $_GET['ids']);
    $id_array = array_map('intval', $id_array); 
    $placeholders = implode(',', array_fill(0, count($id_array), '?'));

    $query = "SELECT 
                ti.control_number, 
                ti.section,
                ti.customer,
                ti.technician_name,
                ti.date_of_verification,
                ti.quarter,
                ts.deformation_status,
                ts.corrosion_status,
                ts.crack_status,
                ts.foreign_material_status,
                ts.alignment_status,
                ts.total_ok,
                ts.total_ng,
                tr.replacement_required,
                tr.terminal_part_no,
                tr.reason_replacement,
                tr.date_replaced
              FROM terminal_inspections ti
              LEFT JOIN terminal_status ts ON ti.id = ts.inspection_id
              LEFT JOIN terminal_replacement tr ON ti.id = tr.inspection_id
              WHERE ti.id IN ($placeholders)";

    $stmt = $conn->prepare($query);
    $types = str_repeat('i', count($id_array));
    $stmt->bind_param($types, ...$id_array);
    $stmt->execute();
    $result = $stmt->get_result();

    $filename = "Terminal_Report_" . date('Y-m-d_H-i') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    fputcsv($output, array(
        'Control No.', 
        'Section', 
        'Customer', 
        'Technician', 
        'Date Verified', 
        'Quarter',
        'Deformation',
        'Corrosion',
        'Crack',
        'Foreign Material',
        'Alignment',
        'Total OK',
        'Total NG',
        'Replacement Req?',
        'Part No.',
        'Replacement Reason',
        'Date Replaced'
    ));

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }

    fclose($output);
    exit();

} else {
    echo "<script>
            alert('Error: No records selected for export.');
            window.history.back();
          </script>";
}
?>