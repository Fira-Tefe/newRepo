<?php
// Enable error reporting to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

// Validate the incoming request
if (isset($_POST['id']) && isset($_POST['restore'])) {
    $id = intval($_POST['id']);
    $restore = ($_POST['restore'] === 'ON') ? 'ON' : 'OFF';

    // Update the Restore status in itstorerecords
    $stmt = $conn->prepare("UPDATE itstorerecords SET Restore = ? WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param('si', $restore, $id);

    if ($stmt->execute()) {
        // Fetch records with Restore = 'ON'
        $selectQuery = "SELECT * FROM itstorerecords WHERE Restore = 'ON'";
        $selectResult = $conn->query($selectQuery);

        if ($selectResult && $selectResult->num_rows > 0) {
            while ($row = $selectResult->fetch_assoc()) {
                $idrestore = $row["id"];
                $namerestore = $row["name"];
                $imagerestore = $row["image"];
                $Approvalrestore = "OFF";
                $Declinerestore = "OFF";
                $departmentrestore = $row["Departments"];
                $Assign = "OFF";
                $emailB = $row["email"];
                $phoneB = $row["phonenumber"];

                // Insert data into itdepartmenttable
                $insertStmt = $conn->prepare(
                    "INSERT INTO itdepartmenttable 
                    (id, name, image, Approval, Decline, Departments, Assign, email, phonenumber) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );

                if (!$insertStmt) {
                    die("Insert preparation failed: " . $conn->error);
                }

                // Bind parameters correctly
                $insertStmt->bind_param(
                    "issssssss",
                    $idrestore, $namerestore, $imagerestore, $Approvalrestore,
                    $Declinerestore, $departmentrestore, $Assign, $emailB, $phoneB
                );

                if ($insertStmt->execute()) {
                    $selectQueryRecordOffice = "SELECT * FROM rejectedmessages WHERE id = '$idrestore'";
                    $selectResultRO = $conn->query($selectQueryRecordOffice);
                      
                    if ($selectResultRO && $selectResultRO->num_rows > 0) {
                        while ($row = $selectResultRO->fetch_assoc()) {
                            $deleteStmtRO = $conn->prepare("DELETE FROM rejectedmessages WHERE id = '$idrestore'");
                            if ($deleteStmtRO->execute()) {
                               // Delete the record from itstorerecords after successful insertion
                                $deleteStmt = $conn->prepare("DELETE FROM itstorerecords WHERE id = ?");
                                $deleteStmt->bind_param("i", $idrestore);

                                if ($deleteStmt->execute()) {
                                    echo "<script>
                                        alert('Record transferred and deleted successfully!');
                                        window.location.href = './recordOfficeAdmin.php';
                                    </script>";
                                    exit;
                                } else {
                                    echo "<script>
                                        alert('Failed to delete the record from itstorerecords.');
                                        window.location.href = './recordOfficeAdmin.php';
                                    </script>";
                                    exit;
                                }
                            }
                        }
                    }
                    
                } else {
                    echo "<script>alert('Insertion failed: " . $insertStmt->error . "');</script>";
                }

                // Close the insert statement
                $insertStmt->close();
            }
        } else {
            echo "No records with Restore = 'ON' found.";
        }
    } else {
        echo "Failed: " . $stmt->error;
    }

    // Close the update statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
