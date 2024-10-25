<?php
    include '../connection.php';
    
    // Retrieve the form data
    $previousName = $_POST["previousFullname"];
    $previousPassword = $_POST["previousPassword"];
    $newName = $_POST["newFullname"];
    $newUsername = $_POST["setUsername"];
    $newPassword = $_POST["setPassword"];
    $confirmPassword = $_POST["seCpassword"];

    // Check if the new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        echo "<script>
                alert('Comfirmation password is different from new Password,Please try again!');
                window.location.href = './recordofficeAdmin.php';
              </script>";
        exit();
    }

    // Prepare the SQL select statement to check for the admin
    $rselect = $conn->prepare("SELECT * FROM itadmintable WHERE fullname = ? AND password = ?");
    $rselect->bind_param("ss", $previousName, $previousPassword);
    $rselect->execute();
    $rresult = $rselect->get_result();

    // If an admin with the previous fullname and password exists
    if ($rresult->num_rows > 0) {
        // Prepare the SQL update statement
        $updateAdmin = $conn->prepare("UPDATE itadmintable SET fullname = ?, username = ?, password = ? WHERE fullname = ? AND password = ?");
        $updateAdmin->bind_param("sssss", $newName, $newUsername, $newPassword, $previousName, $previousPassword);

                // Execute the update statement
                if ($updateAdmin->execute()) {
                    echo "<script>
                            alert('Admin details updated successfully!');
                            window.location.href = './recordofficeAdmin.php';
                        </script>";
                    exit();
                } else {
                    echo "<script>
                            alert('Failed to update admin details. Please try again.');
                            window.location.href = './recordofficeAdmin.php';
                        </script>";
                    exit();
                }
            
    } else {
        // If no matching admin is found
        echo "<script>
                alert('Invalid Fullname or Password!');
                window.location.href = './recordofficeAdmin.php';
              </script>";
        exit();
    }
?>
