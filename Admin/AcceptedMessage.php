<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

if (isset($_POST['id']) && isset($_POST['send'])) {
    $id = intval($_POST['id']);
    $send = ($_POST['send'] === 'ON') ? 'ON' : 'OFF';

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE acceptedletters SET send = ? WHERE id = ?");
        $stmt->bind_param('si', $send, $id);
        if($stmt->execute()){

        // Now select records with send = 'ON'
        $SelectForSend = "SELECT * FROM acceptedletters WHERE send = 'ON'";
        $selectResult = $conn->query($SelectForSend);

        if ($selectResult && $selectResult->num_rows > 0) {
            while ($row = $selectResult->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                $image = $row["image"];
                $Department = $row["Departments"];
                $email = $row["email"];
                $phonenumber = $row["phonenumber"];
                $assign = 'OFF';

                // use PHPMailer\PHPMailer\PHPMailer;
                // use PHPMailer\PHPMailer\Exception;

                require './PHPMailer/src/Exception.php';
                require './PHPMailer/src/PHPMailer.php';
                require './PHPMailer/src/SMTP.php';
                $sender_name ="Ministry of Innovation and Technology Ethiopia";
                $sender_email ="firaolteferi90@gmail.com";
                $recipient_email = $email;
                $subject = "Approved Letter";
                $body = "This is Approval Messages for Ministry of Innovation and Technology of Ethiopia, Your letter was approved";
                        if(mail($recipient_email,$subject,$body,"From: $sender_name<$sender_email>")){
                            // successed
                        }
                        else{
                            echo "something went wrong, Related to email address";
                        }

                // Insert into itacceptedsend
                $insertStmt = $conn->prepare(
                    "INSERT INTO itacceptedsend (id, name, image, Departments, email, phonenumber, Assign) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                $insertStmt->bind_param(
                    "issssss", $id, $name, $image, $Department, $email, $phonenumber, $assign
                );

                if (!$insertStmt->execute()) {
                    throw new Exception("Insert failed: " . $insertStmt->error);
                }
                $insertStmt->close();
                if(true){
                    $storeDeletedFile = "INSERT INTO approvestoreRecords (id, name, image, Approval, Decline, Departments,email,phonenumber)
                    VALUES ('$id', '$name', '$image', 'ON', 'OFF', '$Department','$email','$phonenumber')";
                   if($conn->query($storeDeletedFile) === true){
                        // Delete from itdepartmenttable
                        $deleteStmt = $conn->prepare("DELETE FROM acceptedletters WHERE id = ?");
                        $deleteStmt->bind_param("i", $id);

                        if (!$deleteStmt->execute()) {
                            throw new Exception("Delete failed: " . $deleteStmt->error);
                        }
                        $deleteStmt->close();
                   }
                }
            }
        }

        // Commit the transaction after all inserts and deletes
        $conn->commit();
        echo "Operation successful!";
    }

    } catch (Exception $e) {
        // Roll back the transaction if any query fails
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    echo "Invalid request!";
}
?>
