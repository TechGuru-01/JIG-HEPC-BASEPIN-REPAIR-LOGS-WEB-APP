<?php
require_once "config.php";
$status = "";
$msg_text = "";
if ($_SERVER['REQUEST_METHOD']=='POST'){
    //terminal_inspections
    $section = $_POST['section'] ?? '';
    $control_number = $_POST['control_number'] ?? '';
    $technician_name = $_POST['technician_name'] ?? '';
    $date_of_verification = $_POST['date_of_verification'] ?? NULL;
    $quarter = $_POST['quarter'] ?? '';

    //terminal_status
    $deformation_status	 = $_POST['deformation_status'] ?? '';
    $deformation_remarks = $_POST['deformation_remarks'] ?? '';
    $corrosion_status = $_POST['corrosion_status'] ?? '';
    $corrosion_remarks = $_POST['corrosion_remarks'] ?? '';
    $crack_status = $_POST['crack_status'] ?? '';
    $crack_remarks = $_POST['crack_remarks'] ?? '';
    $foreign_material_status = $_POST['foreign_material_status'] ?? '';
    $foreign_material_remarks = $_POST['foreign_material_remarks'] ?? '';
    $alignment_status = $_POST['alignment_status'] ?? '';
    $alignment_remarks = $_POST['alignment_remarks'] ?? '';
    $total_inspected = $_POST['total_inspected'] ?? 0;
    $total_ok = $_POST['total_ok'] ?? 0;
    $total_ng = $_POST['total_ng'] ?? 0;

    //terminal_replacement
    $replacement_required = $_POST['replacement_required'] ?? 'N/A';
    $terminal_part_no = $_POST['terminal_part_no'] ?? 'N/A';
    $reason_replacement = $_POST['reason_replacement'] ?? 'N/A';
    $date_replaced = $_POST['date_replaced'] ?? NULL;
    $replacement_technician = $_POST['replacement_technician'] ?? 'N/A';
    $change_point_no = $_POST['change_point_no'] ?? 'N/A';

    // Validation
    if(empty($section) || empty($control_number) || empty($technician_name) || empty($date_of_verification) || empty($quarter)){
        $status = "error";
        $msg_text = "Please fill in all Header Information (Section, Control No, Technician, etc.)";
    } 
    elseif (empty($deformation_status) || empty($corrosion_status) || empty($crack_status) || empty( $foreign_material_status) || empty($alignment_status)) {
        $status = "error";
        $msg_text = "Inspection results are incomplete. Please provide a status for all fields (OK/NG).";
    }
    elseif (empty($deformation_remarks) || empty($corrosion_remarks) || empty($crack_remarks) || empty( $foreign_material_remarks) || empty($alignment_remarks)) {
        $status = "error";
        $msg_text = "Inspection results are incomplete. Please provide a status for all fields (Remarks).";
    }
    elseif ($replacement_required == 'yes' && empty($_POST['terminal_part_no'])) {
        $status = "error";
        $msg_text = "Replacement details are required since you selected 'Yes'.";
    }
    else{
        // Insert Photos
        $target_dir = __DIR__ . "/../src/uploads/";
        $photo_before_path = time() . "_before_" . basename($_FILES["photo_before"]["name"]);
        move_uploaded_file($_FILES["photo_before"]["tmp_name"], $target_dir . $photo_before_path);

        $photo_after_path = "";
        if (!empty($_FILES['photo_after']['name'])) {
            $photo_after_path = time() . "_after_" . basename($_FILES["photo_after"]["name"]);
            move_uploaded_file($_FILES["photo_after"]["tmp_name"], $target_dir . $photo_after_path);
        }
        try{
            // Insert Queries
            $stmt1 = $conn->prepare("INSERT INTO terminal_inspections(section, control_number, technician_name, date_of_verification, quarter, photo_before_path, photo_after_path) VALUES(?,?,?,?,?,?,?) ");
            $stmt1->bind_param("sssssss", $section, $control_number, $technician_name, $date_of_verification, $quarter, $photo_before_path, $photo_after_path);
            //Execute
            if($stmt1->execute()){
                $inspection_id = $conn->insert_id;
                $stmt2 = $conn->prepare("INSERT INTO terminal_status(inspection_id, deformation_status, deformation_remarks, corrosion_status, corrosion_remarks, 
                                                            crack_status, crack_remarks, foreign_material_status, foreign_material_remarks, 
                                                            alignment_status, alignment_remarks, total_inspected, total_ok, total_ng)
                                                            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt2->bind_param("issssssssssiii", $inspection_id, $deformation_status, $deformation_remarks, $corrosion_status, $corrosion_remarks, 
                                    $crack_status, $crack_remarks, $foreign_material_status, $foreign_material_remarks, $alignment_status,
                                    $alignment_remarks, $total_inspected, $total_ok, $total_ng);

                $stmt3 = $conn->prepare("INSERT INTO terminal_replacement(inspection_id, replacement_required, terminal_part_no, reason_replacement, date_replaced, replacement_technician, change_point_no)VALUES(?,?,?,?,?,?,?)");
                $stmt3->bind_param("issssss", $inspection_id, $replacement_required, $terminal_part_no, $reason_replacement, $date_replaced, $replacement_technician, $change_point_no);

                if($stmt2->execute() && $stmt3->execute()){
                    $status = "success";
                    $msg_text = "Basepin Inspection Record Saved Successfully";
                }
                else {
                    $status = "error";
                    $msg_text = "Record saved, but sub-tables failed: " . $conn->error;
                }
            }
        } catch (Exception $e) {
            $status = "error";
            $msg_text = "Database Error: " . $e->getMessage();
        }
              
    }
    header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'msg' => $msg_text
        ]);
        exit; 
}
?>