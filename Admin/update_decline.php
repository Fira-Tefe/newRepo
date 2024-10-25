<?php
// Enable error reporting to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

// Validate the incoming request
if (isset($_POST['id']) && isset($_POST['Decline'])) {
    $id = intval($_POST['id']);
    $declineStatus = ($_POST['Decline'] === 'ON') ? 'ON' : 'OFF';

    // Update the Decline status in itdepartmenttable
    $stmt = $conn->prepare("UPDATE itdepartmenttable SET Decline = ? WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param('si', $declineStatus, $id);

    if ($stmt->execute()) {
        // Fetch records with Decline = 'ON'
        $selectQuery = "SELECT * FROM itdepartmenttable WHERE Decline = 'ON'";
        $selectResult = $conn->query($selectQuery);

        if ($selectResult && $selectResult->num_rows > 0) {
            while ($row = $selectResult->fetch_assoc()) {
                $idrestore = $row['id'];
                $namerestore = $row['name'];
                $imagerestore = $row['image'];
                $Declinerestore = 'OFF';
                $departmentrestore = $row['Departments'];
                $restore = 'OFF';
                $emailB = $row['email'];
                $phoneB = $row['phonenumber'];

                // Insert the selected record into itstorerecords
                $insertStmt = $conn->prepare(
                    "INSERT INTO rejectedmessages (id, name, image, Decline, Departments, Restore, email, phonenumber) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                );

                if (!$insertStmt) {
                    die("Insert preparation failed: " . $conn->error);
                }

                $insertStmt->bind_param(
                    "isssssss",
                    $idrestore, $namerestore, $imagerestore, $Declinerestore, 
                    $departmentrestore, $restore, $emailB, $phoneB
                );

                if ($insertStmt->execute()) {
                    // Delete the record from itdepartmenttable after successful insertion
                    $deleteStmt = $conn->prepare("DELETE FROM itdepartmenttable WHERE id = ?");
                    if (!$deleteStmt) {
                        die("Delete preparation failed: " . $conn->error);
                    }

                    $deleteStmt->bind_param("i", $idrestore);

                    if ($deleteStmt->execute()) {
                        echo "<script>
                            alert('Record transferred and deleted successfully!');
                            window.location.href = './recordOfficeAdmin.php';
                        </script>";
                        exit;
                    } else {
                        echo "<script>
                            alert('Failed to delete the record.');
                            window.location.href = './recordOfficeAdmin.php';
                        </script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('Insertion failed: " . $insertStmt->error . "');</script>";
                }

                // Close insert statement
                $insertStmt->close();
            }
        } else {
            echo "No records with Decline = 'ON' found.";
        }
    } else {
        echo "Update failed!";
    }

    // Close statements and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
