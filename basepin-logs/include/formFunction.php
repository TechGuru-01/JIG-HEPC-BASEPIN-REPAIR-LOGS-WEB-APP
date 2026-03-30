<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $control_number = $_POST['control_number'] ?? '';

    $path = '../src/uploads';
    $target_dir = "uploads/";
   $photo_before_path = ""; 
    if (!empty($_FILES['photo_before']['name'])) {
        $photo_before_path = time() . "_before_" . basename($_FILES["photo_before"]["name"]);
        move_uploaded_file($_FILES["photo_before"]["tmp_name"], $target_dir . $photo_before_path);
    }

    
    $photo_after_path = "";
    if (!empty($_FILES['photo_after']['name'])) {
        $photo_after_path = time() . "_after_" . basename($_FILES["photo_after"]["name"]);
        move_uploaded_file($_FILES["photo_after"]["tmp_name"], $target_dir . $photo_after_path);
    }
    //insert
    //bind
    //check
}
?>