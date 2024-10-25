<?php
// Include database connection
include "../connection.php"; // Ensure the path to your connection file is correct

// Get the ID and new status from the POST request
$id = $_POST['id'];
$newStatus = $_POST['restore']; // 'ON' or 'OFF'

// Prepare and bind
$stmt = $conn->prepare("UPDATE rejectedmessages SET Restore = ? WHERE id = ?");
$stmt->bind_param("si", $newStatus, $id);

// Execute the query
if ($stmt->execute()) {
        $Selectrestore = "SELECT * FROM rejectedmessages WHERE Restore = 'ON'";
        $selectResult = $conn->query($Selectrestore);

        if ($selectResult && $selectResult->num_rows > 0) {
            while ($row = $selectResult->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                $image = $row["image"];
                $Department = $row["Departments"];
                $email = $row["email"];
                $phonenumber = $row["phonenumber"];
                $approve = 'OFF';
                $decline = 'OFF';


                // Insert into itacceptedsend
                $insertStmt = $conn->prepare(
                    "INSERT INTO tb_upload (id, name, image, Departments, email, phonenumber, Approval, Decline) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $insertStmt->bind_param(
                    "isssssss", $id, $name, $image, $Department, $email, $phonenumber, $approve, $decline
                );

                if (!$insertStmt->execute()) {
                    throw new Exception("Insert failed: " . $insertStmt->error);
                }
                $insertStmt->close();

                // Delete from itdepartmenttable
                $deleteStmt = $conn->prepare("DELETE FROM rejectedmessages WHERE id = ?");
                $deleteStmt->bind_param("i", $id);

                if (!$deleteStmt->execute()) {
                    throw new Exception("Delete failed: " . $deleteStmt->error);
                }
                $deleteStmt->close();
            }
        }
} else {
    echo "Error updating status: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
