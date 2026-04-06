<?php
require_once "auth_checker.php";
require_once "config.php";

if ($user_role !== 'admin') {
    echo json_encode(['status' => 'error', 'msg' => 'Unauthorized Access']);
    exit;
}

$action = $_POST['action'] ?? '';
$target_id = $_POST['user_id'] ?? 0;

if ($action === 'delete_user') {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $target_id);
    if ($stmt->execute()) echo json_encode(['status' => 'success', 'msg' => 'User removed.']);
} 
elseif ($action === 'reset_pass') {
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_pass, $target_id);
    if ($stmt->execute()) echo json_encode(['status' => 'success', 'msg' => 'Password reset.']);
}
?>