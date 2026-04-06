<?php
require_once __DIR__ . '/config.php';
$status = "";
$msg_text = "";

// --- 1. FETCH SINGLE RECORD PARA SA MODAL (AJAX GET) ---
if (isset($_GET['fetch_id'])) {
    $id = intval($_GET['fetch_id']);
    
    $fetch_sql = "SELECT ti.*, ts.*, tr.* FROM terminal_inspections ti
                  LEFT JOIN terminal_status ts ON ti.id = ts.inspection_id
                  LEFT JOIN terminal_replacement tr ON ti.id = tr.inspection_id
                  WHERE ti.id = ?";
                  
    $stmt = $conn->prepare($fetch_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = $res->fetch_assoc();

    header('Content-Type: application/json');
    if ($data) {
        // Siguraduhin na tama ang path ng uploads folder mo
        $data['photo_before_url'] = "../src/uploads/" . $data['photo_before_path'];
        $data['photo_after_url'] = "../src/uploads/" . $data['photo_after_path'];
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Record not found']);
    }
    exit;
}

// --- 2. DELETE LOGIC (AJAX POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id']; 
    $control_number = $_POST['control_number'] ?? 'Record';

    $delete_sql = $conn->prepare("DELETE ti, ts, tr 
            FROM terminal_inspections ti
            LEFT JOIN terminal_status ts ON ti.id = ts.inspection_id
            LEFT JOIN terminal_replacement tr ON ti.id = tr.inspection_id
            WHERE ti.id = ?");
    $delete_sql->bind_param('i', $id);

    header('Content-Type: application/json');
    if ($delete_sql->execute()) {
        echo json_encode(['status' => 'success', 'msg' => "$control_number deleted successfully."]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => "Failed to delete: " . $conn->error]);
    }
    exit; 
}

// --- 3. TABLE DISPLAY & SEARCH LOGIC ---
$cols = ['section', 'control_number', 'technician_name', 'date_of_verification'];
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