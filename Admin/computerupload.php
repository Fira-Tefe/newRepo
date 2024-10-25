<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "computeruploads/";

    // Check if the directory exists; if not, create it
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $computerdefault_image = 'computeruploads/profile.jpg'; // Default image path
    $target_file = $target_dir . basename($_FILES["computerprofile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the uploaded file is an image
    $check = getimagesize($_FILES["computerprofile_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["computerprofile_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["computerprofile_image"]["tmp_name"], $target_file)) {
            $_SESSION['computerprofile_image'] = $target_file; // Store image path in session
            header('Location: ./recordofficeAdmin.php');
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
