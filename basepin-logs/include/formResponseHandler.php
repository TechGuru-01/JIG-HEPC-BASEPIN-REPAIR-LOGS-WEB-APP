<?php
require_once "config.php";

$status = "";
$msg_text = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. COMMON HEADER DATA (Isang beses lang ito per form submission)
    $section = trim($_POST['section'] ?? '');
    $control_number = trim($_POST['control_number'] ?? '');
    $technician_name = trim($_POST['technician_name'] ?? '');
    $customer = trim($_POST['customer'] ?? '');
    $item_key = trim($_POST['item_key'] ?? '');
    $date_of_verification = $_POST['date_of_verification'] ?? NULL;
    $quarter = $_POST['quarter'] ?? '';

    // Replacement info (Common summary)
    $replacement_required = $_POST['replacement_required'] ?? 'no';
    $reason_replacement = trim($_POST['reason_replacement'] ?? 'N/A');
    $date_replaced = !empty($_POST['date_replaced']) ? $_POST['date_replaced'] : NULL;
    $replacement_technician = trim($_POST['replacement_technician'] ?? 'N/A');
    $change_point_no = trim($_POST['change_point_no'] ?? 'N/A');

    // 2. VALIDATION FOR HEADER
    if (empty($section) || empty($control_number) || empty($technician_name) || empty($date_of_verification) || empty($quarter)) {
        $status = "error";
        $msg_text = "Please fill in all Header Information.";
    } 
    elseif ($replacement_required == 'yes' && (empty($reason_replacement) || empty($date_replaced))) {
        $status = "error";
        $msg_text = "Replacement details are required when 'Yes' is selected.";
    } 
    elseif (!isset($_POST['terminal_part_no']) || !is_array($_POST['terminal_part_no'])) {
        $status = "error";
        $msg_text = "No terminal data detected. Please generate rows first.";
    } 
    else {
        $target_dir = __DIR__ . "/../src/uploads/";
        $success_count = 0;
        $total_rows = count($_POST['terminal_part_no']);

        try {
            // Simulan ang Loop base sa dami ng Part Numbers
            foreach ($_POST['terminal_part_no'] as $index => $part_no) {
                $i = $index + 1; // Counter para sa dynamic radio names (e.g. status_1, status_2)

                // Row-specific data
                $current_no = $_POST['no'][$index] ?? '';
                $current_part_no = trim($part_no);

                // Dynamic Radio Button Names (deformation_status_1, deformation_status_2, etc.)
                $def_status = $_POST["deformation_status_$i"] ?? '';
                $corr_status = $_POST["corrosion_status_$i"] ?? '';
                $crack_status = $_POST["crack_status_$i"] ?? '';
                $mat_status = $_POST["foreign_material_status_$i"] ?? '';
                $align_status = $_POST["alignment_status_$i"] ?? '';

                // Remarks Arrays
                $def_rem = trim($_POST['deformation_remarks'][$index] ?? '');
                $corr_rem = trim($_POST['corrosion_remarks'][$index] ?? '');
                $crack_rem = trim($_POST['crack_remarks'][$index] ?? '');
                $mat_rem = trim($_POST['foreign_material_remarks'][$index] ?? '');
                $align_rem = trim($_POST['alignment_remarks'][$index] ?? '');

                // Count OK/NG for this specific row
                $row_stats = [$def_status, $corr_status, $crack_status, $mat_status, $align_status];
                $total_ok = 0; $total_ng = 0;
                foreach ($row_stats as $s) {
                    if (strtoupper($s) == 'OK') $total_ok++;
                    elseif (strtoupper($s) == 'NG') $total_ng++;
                }

                // Handle Multi-Row Photo Uploads
                $p_before_path = "";
                $p_after_path = "";

                if (!empty($_FILES['photo_before']['name'][$index])) {
                    $p_before_path = time() . "_row{$i}_before_" . basename($_FILES['photo_before']['name'][$index]);
                    move_uploaded_file($_FILES['photo_before']['tmp_name'][$index], $target_dir . $p_before_path);
                }

                if (!empty($_FILES['photo_after']['name'][$index])) {
                    $p_after_path = time() . "_row{$i}_after_" . basename($_FILES['photo_after']['name'][$index]);
                    move_uploaded_file($_FILES['photo_after']['tmp_name'][$index], $target_dir . $p_after_path);
                }

                // --- DATABASE TRANSACTIONS ---

                // INSERT 1: Inspections table
                $stmt1 = $conn->prepare("INSERT INTO terminal_inspections(section, control_number, technician_name, customer, item_key, date_of_verification, quarter, photo_before_path, photo_after_path, no, terminal_part_no) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $stmt1->bind_param("sssssssssss", $section, $control_number, $technician_name, $customer, $item_key, $date_of_verification, $quarter, $p_before_path, $p_after_path, $current_no, $current_part_no);

                if ($stmt1->execute()) {
                    $inspection_id = $conn->insert_id;

                    // INSERT 2: Status Details table
                    $stmt2 = $conn->prepare("INSERT INTO terminal_status(inspection_id, deformation_status, deformation_remarks, corrosion_status, corrosion_remarks, crack_status, crack_remarks, foreign_material_status, foreign_material_remarks, alignment_status, alignment_remarks, total_ok, total_ng) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt2->bind_param("issssssssssii", $inspection_id, $def_status, $def_rem, $corr_status, $corr_rem, $crack_status, $crack_rem, $mat_status, $mat_rem, $align_status, $align_rem, $total_ok, $total_ng);
                    $stmt2->execute();

                    
                    $stmt3 = $conn->prepare("INSERT INTO terminal_replacement(inspection_id, replacement_required, reason_replacement, date_replaced, replacement_technician, change_point_no) VALUES(?,?,?,?,?,?)");
                    $stmt3->bind_param("isssss", $inspection_id, $replacement_required, $reason_replacement, $date_replaced, $replacement_technician, $change_point_no);
                    $stmt3->execute();

                    $success_count++;
                }
            }

            if ($success_count == $total_rows) {
                $status = "success";
                $msg_text = "All $success_count records saved successfully.";
            } else {
                $status = "warning";
                $msg_text = "Saved $success_count out of $total_rows records.";
            }

        } catch (Exception $e) {
            $status = "error";
            $msg_text = "Database Error: " . $e->getMessage();
        }
    }

    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'msg' => $msg_text]);
    exit;
}