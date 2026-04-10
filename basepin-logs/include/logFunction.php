<?php
require_once __DIR__ . '/config.php';
$cols = ['section', 'control_number', 'technician_name', 'date_of_verification'];


if (isset($_GET['fetch_id'])) {
    ob_clean(); 
    header('Content-Type: application/json');

    $id = intval($_GET['fetch_id']);
    

    $stmt1 = $conn->prepare("SELECT * FROM terminal_inspections WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $header_data = $stmt1->get_result()->fetch_assoc();

    if ($header_data) {
        $stmt2 = $conn->prepare("SELECT * FROM terminal_status WHERE inspection_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $terminals_res = $stmt2->get_result();
        
        $terminals = [];
        while ($row = $terminals_res->fetch_assoc()) {
            $row['photo_before_url'] = "../../src/uploads/" . $row['photo_before_path'];
            $row['photo_after_url'] = "../../src/uploads/" . $row['photo_after_path'];
            $terminals[] = $row;
        }

     
        $stmt3 = $conn->prepare("SELECT * FROM terminal_replacement WHERE inspection_id = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $replacement_res = $stmt3->get_result();

        $replacements = [];
        while ($rep_row = $replacement_res->fetch_assoc()) {
            $replacements[] = $rep_row;
        }

        $final_output = $header_data;
        $final_output['terminals'] = $terminals;
        $final_output['replacements'] = $replacements; 

        echo json_encode(['status' => 'success', 'data' => $final_output]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Record not found']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    ob_clean();
    header('Content-Type: application/json');
    $id = intval($_POST['delete_id']);
    
    $conn->query("DELETE FROM terminal_status WHERE inspection_id = $id");
    $conn->query("DELETE FROM terminal_replacement WHERE inspection_id = $id");
    $delete_main = $conn->prepare("DELETE FROM terminal_inspections WHERE id = ?");
    $delete_main->bind_param('i', $id);

    if ($delete_main->execute()) {
        echo json_encode(['status' => 'success', 'msg' => "Deleted successfully."]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => $conn->error]);
    }
    exit;
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$dateFrom = isset($_GET['dateFrom']) ? mysqli_real_escape_string($conn, $_GET['dateFrom']) : '';
$dateTo = isset($_GET['dateTo']) ? mysqli_real_escape_string($conn, $_GET['dateTo']) : '';

$sql = "SELECT * FROM terminal_inspections WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (control_number LIKE '%$search%' OR technician_name LIKE '%$search%')";
}

if (!empty($dateFrom) && !empty($dateTo)) {
    $sql .= " AND date_of_verification BETWEEN '$dateFrom' AND '$dateTo'";
}

$sql .= " ORDER BY date_of_verification DESC";
$result = mysqli_query($conn, $sql); 
?>