<?php
require '../connection.php';

// Check if the request method is POST and necessary data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rowId']) && isset($_POST['actionType']) && isset($_POST['status'])) {
    $rowId = intval($_POST['rowId']);
    $actionType = $_POST['actionType'];
    $status = $_POST['status'];
    $department = isset($_POST['department']) ? $_POST['department'] : '';

    // Handle the approve action
    if ($actionType === 'approve') {
        $query = "UPDATE tb_upload SET Approval = ?, Departments = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, 'ssi', $status, $department, $rowId);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('updated fira!');</script>";
                echo json_encode(['status' => 'success', 'message' => 'Row updated successfully']);

            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating the row: ' . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error preparing SQL statement']);
        }

    // Handle the decline action
    } elseif ($actionType === 'decline') {
        $query = "UPDATE tb_upload SET Decline = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, 'si', $status, $rowId);
            if (mysqli_stmt_execute($stmt)) {
                if ($status === 'ON') {
                    mysqli_begin_transaction($conn);
                    try {
                        $selectDecline = "SELECT * FROM tb_upload WHERE Decline = 'ON'";
                        $selectDeclineResult = $conn->query($selectDecline);
                        if($selectDeclineResult->num_rows > 0) {
                            while($row = $selectDeclineResult->fetch_assoc()) {
                                $idrestore = $row["id"];
                                $namerestore = $row["name"];
                                $imagerestore = $row["image"];
                                $Approvalrestore = $row["Approval"];
                                $Declinerestore = $row["Decline"];
                                $departmentrestore = $row["Departments"];
                                $emailD = $row["email"];
                                $phonenumber = $row["phonenumber"];

                                $getStore = "INSERT INTO storeRecords (id, name, image, Approval, Decline, Departments,Restore,email,phonenumber)
                                VALUES ('$idrestore', '$namerestore', '$imagerestore', '$Approvalrestore', '$Declinerestore', '$departmentrestore','OFF','$emailD','$phonenumber')";
                                if ($conn->query($getStore) === TRUE) {
                                    $selectForEmail = "SELECT * FROM `tb_upload` WHERE Decline = 'ON'";
                                    $forSendEmail = $conn->query($selectForEmail);

                                        if ($forSendEmail->num_rows > 0) {
                                            while ($row = $forSendEmail->fetch_assoc()) {
                                                // use PHPMailer\PHPMailer\PHPMailer;
                                                // use PHPMailer\PHPMailer\Exception;

                                                require './PHPMailer/src/Exception.php';
                                                require './PHPMailer/src/PHPMailer.php';
                                                require './PHPMailer/src/SMTP.php';
                                                $sender_name ="Ministry of Innovation and Technology Ethiopia";
                                                $sender_email ="firaolteferi90@gmail.com";
                                                $recipient_email = $row["email"];
                                                $subject = "Declined Letter";
                                                $body = "This is Decline Messages from Ministry of Innovation and Technology of Ethiopia, Sorry,Your letter was Decline!!!";
                                                        if(mail($recipient_email,$subject,$body,"From: $sender_name<$sender_email>")){
                                                            // successed
                                                        }
                                                        else{
                                                            echo "something went wrong, Related to email address";
                                                        }
                                                 }
                                            }
                                   echo "<script>alert('Congra!!!');</script>";
                                }
                                else{
                                    echo "<script>alert('fail!!!');</script>";
                                }
                            }
                        }
                        else{
                            echo "<script>alert('it is not stored!!!');</script>";
                        }
                        $deleteQuery = "DELETE FROM tb_upload WHERE Decline = 'ON'";
                        if (!mysqli_query($conn, $deleteQuery)) {
                            throw new Exception('Failed to delete rows with Decline = ON: ' . mysqli_error($conn));
                        }
                        mysqli_commit($conn);
                        echo json_encode(['status' => 'success', 'message' => 'Rows deleted successfully']);
                        exit;
                    } catch (Exception $e) {
                        mysqli_rollback($conn);
                        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                        exit;
                    }
                } else {
                    echo json_encode(['status' => 'success', 'message' => 'Row updated successfully']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating the row: ' . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error preparing SQL statement']);
        }
    } elseif ($actionType === 'department') {
        // Handle department updates
        $query = "UPDATE tb_upload SET Departments = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, 'si', $status, $rowId);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success', 'message' => 'Department updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating the department: ' . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error preparing SQL statement']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action type']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

mysqli_close($conn);
?>
