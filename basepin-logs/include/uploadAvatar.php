<?php
require_once "auth_checker.php";
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $user_id = $_SESSION['user_id'];
    $file = $_FILES['avatar'];
    
    $target_dir = "../src/profiles/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $new_filename = "profile_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;
    $db_path = "../../src/profiles/" . $new_filename; 
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        echo json_encode(["status" => "error", "msg" => "File is not an image."]);
        exit;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
        $stmt->bind_param("si", $db_path, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "msg" => "Profile picture updated!"]);
        } else {
            echo json_encode(["status" => "error", "msg" => "Database update failed."]);
        }
    } else {
        echo json_encode(["status" => "error", "msg" => "Failed to upload file."]);
    }
}