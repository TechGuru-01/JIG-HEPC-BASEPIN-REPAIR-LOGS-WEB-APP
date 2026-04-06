<?php
require_once __DIR__ . '/config.php';
$status = "";
$msg_text = "";
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $full_name = trim($_POST['full_name']??'');
    $position = trim($_POST['position']??'');
    $username = ($_POST['username']??'');
    $password = $_POST['password']??'';
    $confirm_password = $_POST['confirm_password']??'';

    //validation
    // empty input
    if(empty($full_name)){
        $status = "error";
        $msg_text = "Full name is required.";
    }
    elseif(empty($position)){
        $status = "error";
        $msg_text = "Position is required";
    }
    elseif(empty($username)){
        $status = "error";
        $msg_text = "Username is required";
    }
    elseif(empty($password)){
        $status = "error";
        $msg_text = "Password is required";
    } 
    elseif ($password !== $confirm_password) {
        $status = "error";
        $msg_text = "Passwords do not match!";
    }
    // password policy
    else {

        if (strlen($password) < 8) {
            $status = "error";
            $msg_text = "Password should atleast be 8 characters long";
        } 
        elseif (!preg_match('/[A-Z]/', $password)) {
            $status = 'error';
            $msg_text = 'Password must include atleast one upper case letter';
        } 
        elseif (!preg_match('/[a-z]/', $password)) {
            $status = 'error';
            $msg_text = 'Password must include atleast one lower case letter';
        } 
        elseif (!preg_match('/\d/', $password)) {
            $status = 'error';
            $msg_text = 'Password must include atleast one number';
        }
         elseif (!preg_match('/[$#@!?]/', $password)) {
            $status = 'error';
            $msg_text = 'Password must include atleast one special character';
        } 
        else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            try{
                $check_stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR full_name = ?");
                $check_stmt->bind_param('ss', $username, $full_name);
                $check_stmt->execute();
                $result = $check_stmt->get_result();
                if($row = $result->fetch_assoc()){
                    $status = "error";
                    if($row['username'] == $username){
                        $msg_text = "Username is already taken.";
                    }
                    else{
                        $msg_text = "This person already has a registered account.";
                    }
                }
                else{
                    $stmt = $conn->prepare("INSERT INTO users(full_name, position, username, password) VALUES(?,?,?,?)");
                    $stmt->bind_param('ssss', $full_name, $position, $username, $hashed_password);

                    if($stmt->execute()){
                        $status = "success";
                        $msg_text = "You have signuped successfully";
                    }
                    else{
                        $status = "error";
                        $msg_text = "signup failed" . $conn->error;
                    }
                }
            }catch (Exception $e) {
            $status = "error";
            $msg_text = "Database Error: " . $e->getMessage();
        }

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