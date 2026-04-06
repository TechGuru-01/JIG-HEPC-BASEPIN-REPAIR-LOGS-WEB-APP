<?php
require_once __DIR__ . '/config.php';
$status ="";
$msg_text="";


if($_SERVER['REQUEST_METHOD']=='POST'){
        $id = $_POST['delete_id']; 
        $control_number = $_POST['control_number'];

        $delete_sql = $conn->prepare("DELETE ti, ts, tr 
                FROM terminal_inspections ti
                LEFT JOIN terminal_status ts ON ti.id = ts.inspection_id
                LEFT JOIN terminal_replacement tr ON ti.id = tr.inspection_id
                WHERE ti.id = ?");
        $delete_sql->bind_param('i',$id);

        if($delete_sql->execute()){
                $status = "success";
                $msg_text = "$control_number has been deleted successfully.";
        }
        else{
                $status = "error";
                $msg_text = "Failed to delete: $control_number";
        }
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'msg' => $msg_text
        ]);
        exit; 

}

$cols = ['section','control_number', 'technician_name','date_of_verification'];
$sql = "SELECT * FROM terminal_inspections ORDER BY date_of_verification DESC";
$result = mysqli_query($conn, $sql);

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$dateFrom = isset($_GET['dateFrom']) ? mysqli_real_escape_string($conn, $_GET['dateFrom']) : '';
$dateTo = isset($_GET['dateTo']) ? mysqli_real_escape_string($conn, $_GET['dateTo']) : '';

$sql = "SELECT * FROM terminal_inspections WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND control_number LIKE '%$search%'";
}

if (!empty($dateFrom) && !empty($dateTo)) {
    $sql .= " AND date_of_verification BETWEEN '$dateFrom' AND '$dateTo'";
}

$sql .= " ORDER BY date_of_verification DESC";
$result = mysqli_query($conn, $sql);
?>