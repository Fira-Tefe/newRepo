<?php
// Include database connection
include "../connection.php"; // Ensure the path to your connection file is correct

// Get the ID and new status from the POST request
$id = $_POST['id'];
$newStatus = $_POST['decline']; // 'ON' or 'OFF'

// Prepare and bind
$stmt = $conn->prepare("UPDATE rejectedmessages SET Decline = ? WHERE id = ?");
$stmt->bind_param("si", $newStatus, $id);

// Execute the update query
if ($stmt->execute()) {
    $selectQuery = "SELECT * FROM rejectedmessages WHERE Decline = 'ON'";
    $selectResult = $conn->query($selectQuery);

    if ($selectResult && $selectResult->num_rows > 0) {
        while ($row = $selectResult->fetch_assoc()) {
            $idrestore = $row['id'];
            $namerestore = $row['name'];
            $imagerestore = $row['image'];
            $Approvalrestore = 'OFF';
            $Declinerestore = 'ON';
            $departmentrestore = $row['Departments'];
            $restore = 'OFF';
            $emailB = $row['email'];
            $phoneB = $row['phonenumber'];

            // Insert the selected record into storerecords
            $insertStmt = $conn->prepare(
                "INSERT INTO storerecords (id, name, image, Approval, Decline, Departments, Restore, email, phonenumber) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            if ($insertStmt) {
                $insertStmt->bind_param(
                    "issssssss",
                    $idrestore, $namerestore, $imagerestore, $Approvalrestore, $Declinerestore,
                    $departmentrestore, $restore, $emailB, $phoneB
                );

                if ($insertStmt->execute()) {
                    // Delete the record from rejectedmessages after successful insertion
                    $deleteStmt = $conn->prepare("DELETE FROM rejectedmessages WHERE id = ?");
                    if ($deleteStmt) {
                        $deleteStmt->bind_param("i", $idrestore);
                        if ($deleteStmt->execute()) {
                            // Successfully deleted
                        } else {
                            echo "<script>alert('Failed to delete the record: " . $deleteStmt->error . "');</script>";
                        }
                        $deleteStmt->close();
                    } else {
                        echo "<script>alert('Delete preparation failed: " . $conn->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Insertion failed: " . $insertStmt->error . "');</script>";
                }
                $insertStmt->close();
            } else {
                echo "<script>alert('Insert preparation failed: " . $conn->error . "');</script>";
            }
        }
        echo "<script>
            alert('Records transferred and deleted successfully!');
            window.location.href = './recordOfficeAdmin.php';
        </script>";
    } else {
        echo "<script>alert('No records with Decline = ON found.');</script>";
    }
} else {
    echo "<script>alert('Error updating status: " . $stmt->error . "');</script>";
}

// Close connections
$stmt->close();
$conn->close();
?>
