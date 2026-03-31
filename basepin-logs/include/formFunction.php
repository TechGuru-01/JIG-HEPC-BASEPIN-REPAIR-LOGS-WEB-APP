<?php
$status = ""; 
$msg_text = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture Inputs
    $section = $_POST['section'] ?? '';
    $control_number = $_POST['control_number'] ?? '';
    $technician_name = $_POST['technician_name'] ?? '';
    $date_of_verification = $_POST['date_of_verification'] ?? '';
    $quarter = $_POST['quarter'] ?? '';
    
    // Status and Remarks
    $deformation_status = $_POST['deformation_status'] ?? '';
    $deformation_remarks = $_POST['deformation_remarks'] ?? '';
    $corrosion_status = $_POST['corrosion_status'] ?? '';
    $corrosion_remarks = $_POST['corrosion_remarks'] ?? '';
    $crack_status = $_POST['crack_status'] ?? '';
    $crack_remarks = $_POST['crack_remarks'] ?? '';     
    $foreign_material_status = $_POST['foreign_material_status'] ?? '';
    $foreign_material_remarks = $_POST['foreign_material_remarks'] ?? '';
    $alignment_status = $_POST['alignment_status'] ?? '';
    $alignment_remarks = $_POST['alignment_remarks'] ?? '';
    
    // Totals 
    $total_inspected = (int)($_POST['total_inspected'] ?? 0);
    $total_ok = (int)($_POST['total_ok'] ?? 0);
    $total_ng = (int)($_POST['total_ng'] ?? 0);
    
    // Replacement Info 
    $replacement_required = $_POST['replacement_required'] ?? 'no';
    $terminal_part_no = $_POST['terminal_part_no'] ?? '';
    $reason_replacement = $_POST['reason_replacement'] ?? ''; 
    $date_replaced = !empty($_POST['date_replaced']) ? $_POST['date_replaced'] : null;
    $replacement_technician = $_POST['replacement_technician'] ?? '';
    $change_point_no = $_POST['change_point_no'] ?? '';

    // VALIDATION 
    if (empty($section)) {
        $status = "warning";
        $msg_text = "Please select a section to proceed.";
    } elseif (empty($control_number)) {
        $status = "warning";
        $msg_text = "Control number is required.";
    } elseif (empty($technician_name)) {
        $status = "warning";
        $msg_text = "Please enter the technicians name.";
    } elseif (empty($date_of_verification)) {
        $status = "warning";
        $msg_text = "Please select the date of verification.";
    } elseif (empty($_FILES['photo_before']['name'])) {
        $status = "warning";
        $msg_text = "Before photo is required.";
    } elseif (empty($_FILES['photo_after']['name'])) {
        $status = "warning";
        $msg_text = "After Photo is required.";
    } elseif (empty($deformation_status)) {
        $status = "warning";
        $msg_text = "Please select OK or NG for deformation status.";
    } elseif (empty($deformation_remarks)) {
        $status = "warning";
        $msg_text = "Please add remarks for deformation.";
    } elseif (empty($corrosion_status)) {
        $status = "warning";
        $msg_text = "Please select OK or NG for corrosion status.";
    } elseif (empty($corrosion_remarks)) {
        $status = "warning";
        $msg_text = "Please add remarks for corrosion.";
    } elseif (empty($crack_status)) {
        $status = "warning";
        $msg_text = "Please select OK or NG for crack status.";
    } elseif (empty($crack_remarks)) {
        $status = "warning";
        $msg_text = "Please add remarks for cracks.";
    } elseif (empty($foreign_material_status)) {
        $status = "warning";
        $msg_text = "Please select OK or NG for foreign material status.";
    } elseif (empty($foreign_material_remarks)) {
        $status = "warning";
        $msg_text = "Please add remarks for foreign material.";
    } elseif (empty($alignment_status)) {
        $status = "warning";
        $msg_text = "Please select OK or NG for alignment status.";
    } elseif (empty($alignment_remarks)) {
        $status = "warning";
        $msg_text = "Please add remarks for alignment.";
    } elseif ($total_inspected === "") {    
        $status = "warning";
        $msg_text = "Total Inspected field is required.";
    } elseif ($total_ok === "") {
        $status = "warning";
        $msg_text = "Total OK field is required.";
    } elseif ($total_ng === "") {
        $status = "warning";
        $msg_text = "Total NG field is required.";
    } elseif (empty($replacement_required)) {
        $status = "warning";
        $msg_text = "Please indicate if replacement is required.";
    } else {
       $target_dir = __DIR__ . "/../src/uploads/";
        $photo_before_path = time() . "_before_" . basename($_FILES["photo_before"]["name"]);
        move_uploaded_file($_FILES["photo_before"]["tmp_name"], $target_dir . $photo_before_path);

        $photo_after_path = "";
        if (!empty($_FILES['photo_after']['name'])) {
            $photo_after_path = time() . "_after_" . basename($_FILES["photo_after"]["name"]);
            move_uploaded_file($_FILES["photo_after"]["tmp_name"], $target_dir . $photo_after_path);
        }

        try {
            // SAKTONG 26 COLUMNS (Inalis ang ID at Created_At dahil auto sila sa DB)
            $sql = "INSERT INTO terminal_inspections (
                section, control_number, technician_name, date_of_verification, quarter, 
                photo_before_path, photo_after_path, deformation_status, deformation_remarks, 
                corrosion_status, corrosion_remarks, crack_status, crack_remarks, 
                foreign_material_status, foreign_material_remarks, alignment_status, 
                alignment_remarks, total_inspected, total_ok, total_ng, 
                replacement_required, terminal_part_no, reason_replacement, 
                date_replaced, replacement_technician, change_point_no
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                $types = "ssssssssssssssssssiiisssss"; 

                $stmt->bind_param($types, 
                    $section, $control_number, $technician_name, $date_of_verification, $quarter, 
                    $photo_before_path, $photo_after_path, $deformation_status, $deformation_remarks, 
                    $corrosion_status, $corrosion_remarks, $crack_status, $crack_remarks, 
                    $foreign_material_status, $foreign_material_remarks, $alignment_status, 
                    $alignment_remarks, $total_inspected, $total_ok, $total_ng, 
                    $replacement_required, $terminal_part_no, $reason_replacement, 
                    $date_replaced, $replacement_technician, $change_point_no
                );

                if ($stmt->execute()) {
                    $status = "success";
                    $msg_text = "Inspection record saved successfully!";
                } else {
                    $status = "error";
                    $msg_text = "Database Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $status = "error";
                $msg_text = "SQL Prepare Error: " . $conn->error;
            }
        } catch (Exception $e) {
            $status = "error";
            $msg_text = "System Error: " . $e->getMessage();
        }
    }
}
?>
