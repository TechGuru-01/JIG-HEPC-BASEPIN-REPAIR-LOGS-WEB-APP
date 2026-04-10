<?php
require_once "config.php";

$status = "";
$msg_text = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $section = trim($_POST['section'] ?? '');
    $control_number = trim($_POST['control_number'] ?? '');
    $technician_name = trim($_POST['technician_name'] ?? '');
    $date_of_verification = $_POST['date_of_verification'] ?? NULL;
    $quarter = $_POST['quarter'] ?? '';
    $customer = trim($_POST['customer'] ?? '');
    $item_key = trim($_POST['item_key'] ?? '');
    $replacement_required = $_POST['replacement_required'] ?? 'no';

    if (empty($section) || empty($control_number) || empty($technician_name) || empty($date_of_verification) || empty($quarter) || empty($customer) || empty($item_key)) {
        $status = "error";
        $msg_text = "Please fill in all Header Information.";
    } 
    elseif (!isset($_POST['terminal_part_no']) || !is_array($_POST['terminal_part_no'])) {
        $status = "error";
        $msg_text = "No terminal rows detected. Please generate rows first.";
    }
    else {
        $target_dir = __DIR__ . "/../src/uploads/";
        $conn->begin_transaction();

        try {
            $stmt1 = $conn->prepare("INSERT INTO terminal_inspections(section, control_number, technician_name, customer, item_key, date_of_verification, quarter) VALUES(?,?,?,?,?,?,?)");
            $stmt1->bind_param("sssssss", $section, $control_number, $technician_name, $customer, $item_key, $date_of_verification, $quarter);
            
            if (!$stmt1->execute()) {
                throw new Exception("Failed to save inspection header: " . $stmt1->error);
            }

            $inspection_id = $conn->insert_id;

            foreach ($_POST['terminal_part_no'] as $index => $part_no) {
                $i = $index + 1;
                
                $current_part_no = trim($part_no);
                $current_no = trim($_POST['no'][$index] ?? '');

                $def_status = $_POST["deformation_status_$i"] ?? '';
                $corr_status = $_POST["corrosion_status_$i"] ?? '';
                $crack_status = $_POST["crack_status_$i"] ?? '';
                $mat_status = $_POST["foreign_material_status_$i"] ?? '';
                $align_status = $_POST["alignment_status_$i"] ?? '';

                $def_rem = trim($_POST['deformation_remarks'][$index] ?? '');
                $corr_rem = trim($_POST['corrosion_remarks'][$index] ?? '');
                $crack_rem = trim($_POST['crack_remarks'][$index] ?? '');
                $mat_rem = trim($_POST['foreign_material_remarks'][$index] ?? '');
                $align_rem = trim($_POST['alignment_remarks'][$index] ?? '');

                if (empty($def_status) || empty($corr_status) || empty($crack_status) || empty($mat_status) || empty($align_status)) {
                    throw new Exception("Row $i: Inspection results are incomplete.");
                }

                $p_before = "";
                if (!empty($_FILES["photo_before"]["name"][$index])) {
                    $p_before = time() . "_row{$i}_before_" . basename($_FILES["photo_before"]["name"][$index]);
                    move_uploaded_file($_FILES["photo_before"]["tmp_name"][$index], $target_dir . $p_before);
                }

                $p_after = "";
                if (!empty($_FILES["photo_after"]["name"][$index])) {
                    $p_after = time() . "_row{$i}_after_" . basename($_FILES["photo_after"]["name"][$index]);
                    move_uploaded_file($_FILES["photo_after"]["tmp_name"][$index], $target_dir . $p_after);
                }

                $stmt2 = $conn->prepare("INSERT INTO terminal_status(inspection_id, terminal_part_no, row_no, deformation_status, deformation_remarks, corrosion_status, corrosion_remarks, crack_status, crack_remarks, foreign_material_status, foreign_material_remarks, alignment_status, alignment_remarks, photo_before_path, photo_after_path) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt2->bind_param("issssssssssssss", $inspection_id, $current_part_no, $current_no, $def_status, $def_rem, $corr_status, $corr_rem, $crack_status, $crack_rem, $mat_status, $mat_rem, $align_status, $align_rem, $p_before, $p_after);
                $stmt2->execute();
            }

            if ($replacement_required === 'yes' && isset($_POST['reason_replacement']) && is_array($_POST['reason_replacement'])) {
                $stmt3 = $conn->prepare("INSERT INTO terminal_replacement(inspection_id, replacement_required, reason_replacement, date_replaced, replacement_technician, change_point_no, replacement_terminal_replace_no) VALUES(?,?,?,?,?,?,?)");
                
                foreach ($_POST['reason_replacement'] as $r_index => $reason) {
                    $r_reason = trim($reason);
                    $r_date = !empty($_POST['date_replaced'][$r_index]) ? $_POST['date_replaced'][$r_index] : NULL;
                    $_terminal_no = trim($_POST['replacement_terminal_replace_no'][$r_index] ?? '');
                    $r_tech = trim($_POST['replacement_technician'][$r_index] ?? 'N/A');
                    $r_cp_no = trim($_POST['change_point_no'][$r_index] ?? 'N/A');

                    $stmt3->bind_param("issssss", $inspection_id, $replacement_required, $r_reason, $r_date, $r_tech, $r_cp_no, $_terminal_no);
                    $stmt3->execute();
                }
            }

            $conn->commit();
            $status = "success";
            $msg_text = "All records saved successfully.";

        } catch (Exception $e) {
            $conn->rollback();
            $status = "error";
            $msg_text = $e->getMessage();
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'msg' => $msg_text]);
    exit;
}
?>