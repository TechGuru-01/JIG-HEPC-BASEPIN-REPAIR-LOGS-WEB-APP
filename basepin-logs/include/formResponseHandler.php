<?php
require_once "config.php";
$status = "";
$msg_text = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data
    $section = trim($_POST['section'] ?? '');
    $control_number = trim($_POST['control_number'] ?? '');
    $technician_name = trim($_POST['technician_name'] ?? '');
    $date_of_verification = $_POST['date_of_verification'] ?? NULL;
    $quarter = $_POST['quarter'] ?? '';
    $no = $_POST['no'] ?? '';
    $terminal_part_no = trim($_POST['terminal_part_no'] ?? 'N/A');
    $customer = trim($_POST['customer'] ?? '');
    $item_key = trim($_POST['item_key'] ?? '');

    $deformation_status = $_POST['deformation_status'] ?? '';
    $deformation_remarks = trim($_POST['deformation_remarks'] ?? '');
    $corrosion_status = $_POST['corrosion_status'] ?? '';
    $corrosion_remarks = trim($_POST['corrosion_remarks'] ?? '');
    $crack_status = $_POST['crack_status'] ?? '';
    $crack_remarks = trim($_POST['crack_remarks'] ?? '');
    $foreign_material_status = $_POST['foreign_material_status'] ?? '';
    $foreign_material_remarks = trim($_POST['foreign_material_remarks'] ?? '');
    $alignment_status = $_POST['alignment_status'] ?? '';
    $alignment_remarks = trim($_POST['alignment_remarks'] ?? '');

    $replacement_required = $_POST['replacement_required'] ?? 'no'; // Default to no
    $reason_replacement = trim($_POST['reason_replacement'] ?? 'N/A');
    $date_replaced = $_POST['date_replaced'] ?? NULL;
    $replacement_technician = trim($_POST['replacement_technician'] ?? 'N/A');
    $change_point_no = trim($_POST['change_point_no'] ?? 'N/A');

    // Count OK/NG
    $status_fields = [$deformation_status, $corrosion_status, $crack_status, $foreign_material_status, $alignment_status];
    $total_ok = 0;
    $total_ng = 0;
    foreach ($status_fields as $s) {
        if (strtoupper($s) == 'OK') $total_ok++;
        elseif (strtoupper($s) == 'NG') $total_ng++;
    }

    // Validation
    if (empty($section) || empty($control_number) || empty($technician_name) || empty($date_of_verification) || empty($quarter) || empty($no)) {
        $status = "error";
        $msg_text = "Please fill in all Header Information.";
    } 
    elseif (empty($_FILES["photo_before"]["name"]) || empty($_FILES["photo_after"]["name"])) {
        $status = "error";
        $msg_text = "Please insert both Before and After photos.";
    }
   
    elseif ($replacement_required == 'yes' && (empty($reason_replacement) || empty($date_replaced))) {
        $status = "error";
        $msg_text = "Replacement details are required when 'Yes' is selected.";
    }
    else {
        $target_dir = __DIR__ . "/../src/uploads/";
        $photo_before_path = time() . "_before_" . basename($_FILES["photo_before"]["name"]);
        move_uploaded_file($_FILES["photo_before"]["tmp_name"], $target_dir . $photo_before_path);

        $photo_after_path = time() . "_after_" . basename($_FILES["photo_after"]["name"]);
        move_uploaded_file($_FILES["photo_after"]["tmp_name"], $target_dir . $photo_after_path);

        try {
            // INSERT 1: Inspections
            $stmt1 = $conn->prepare("INSERT INTO terminal_inspections(section, control_number, technician_name, customer, item_key, date_of_verification, quarter, photo_before_path, photo_after_path, no, terminal_part_no) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $stmt1->bind_param("sssssssssss", $section, $control_number, $technician_name, $customer, $item_key, $date_of_verification, $quarter, $photo_before_path, $photo_after_path, $no, $terminal_part_no);

            if ($stmt1->execute()) {
                $inspection_id = $conn->insert_id;

                // INSERT 2: Status
                $stmt2 = $conn->prepare("INSERT INTO terminal_status(inspection_id, deformation_status, deformation_remarks, corrosion_status, corrosion_remarks, crack_status, crack_remarks, foreign_material_status, foreign_material_remarks, alignment_status, alignment_remarks, total_ok, total_ng) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt2->bind_param("issssssssssii", $inspection_id, $deformation_status, $deformation_remarks, $corrosion_status, $corrosion_remarks, $crack_status, $crack_remarks, $foreign_material_status, $foreign_material_remarks, $alignment_status, $alignment_remarks, $total_ok, $total_ng);
                $stmt2->execute();

                // INSERT 3: Replacement 
                $stmt3 = $conn->prepare("INSERT INTO terminal_replacement(inspection_id, replacement_required, reason_replacement, date_replaced, replacement_technician, change_point_no) VALUES(?,?,?,?,?,?)");
                $stmt3->bind_param("isssss", $inspection_id, $replacement_required, $reason_replacement, $date_replaced, $replacement_technician, $change_point_no);
                $stmt3->execute();

                $status = "success";
                $msg_text = "Record Saved Successfully";
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