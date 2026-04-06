<?php
require_once __DIR__ . '/config.php';

$status = "";
$msg_text = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $status = "error";
        $msg_text = "Please enter your username.";
    } elseif (empty($password)) {
        $status = "error";
        $msg_text = "Please enter your password.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username']; 
                    $_SESSION['full_name'] = $row['full_name'] ?? 'User';
                    $_SESSION['position'] = $row['position'];

                    $status = "success";
                    $msg_text = "Login successful!";
                } else {
                    $status = "error";
                    $msg_text = "Invalid username or password.";
                }
            } else {
                $status = "error";
                $msg_text = "Invalid username or password.";
            }
        } catch (Exception $e) {
            $status = "error";
            $msg_text = "System Error: " . $e->getMessage();
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