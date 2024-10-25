<?php
// Enable error reporting to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

// Validate the incoming request
if (isset($_POST['id']) && isset($_POST['restore'])) {
    $id = intval($_POST['id']);
    $restore = ($_POST['restore'] === 'ON') ? 'ON' : 'OFF';

    // Prepare the SQL statement to update only the Restore field
    $stmt = $conn->prepare("UPDATE storerecords SET Restore = ? WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    // Bind the parameters and execute the query
    $stmt->bind_param('si', $restore, $id);
    if ($stmt->execute()) {
        // Select records with 'Restore' set to 'ON'
        $selecteStored = "SELECT * FROM storerecords WHERE Restore = 'ON'";
        $selecteStoredResult = $conn->query($selecteStored);

        if ($selecteStoredResult->num_rows > 0) {
            while ($row = $selecteStoredResult->fetch_assoc()) {
                $idrestore = $row["id"];
                $namerestore = $row["name"];
                $imagerestore = $row["image"];
                $Approvalrestore = "OFF";
                $Declinerestore = "OFF";
                $departmentrestore = $row["Departments"];
                $emailB = $row["email"];
                $phoneB = $row["phonenumber"];
                
                // Insert data into tb_upload table
                $insertSelectedStore = $conn->prepare(
                    "INSERT INTO tb_upload (id, name, image, Approval, Decline, Departments, email, phonenumber) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                );

                if (!$insertSelectedStore) {
                    die("Preparation failed: " . $conn->error);
                }

                // Bind parameters including email and phone number
                $insertSelectedStore->bind_param(
                    "isssssss",
                    $idrestore,
                    $namerestore,
                    $imagerestore,
                    $Approvalrestore,
                    $Declinerestore,
                    $departmentrestore,
                    $emailB,
                    $phoneB
                );

                if ($insertSelectedStore->execute()) {
                    // Delete the record from storerecords after successful insertion
                    $deleteQuery = "DELETE FROM storerecords WHERE id = ?";
                    $deleteStmt = $conn->prepare($deleteQuery);
                    $deleteStmt->bind_param("i", $idrestore);

                    if ($deleteStmt->execute()) {
                        echo "<script>
                            alert('Record transferred and deleted successfully!');
                            window.location.href = './recordOfficeAdmin.php';
                        </script>";
                        exit(0);
                    } else {
                        echo "<script>
                            alert('Failed to delete the record from storerecords.');
                            window.location.href = './recordOfficeAdmin.php';
                        </script>";
                        exit(0);
                    }
                } else {
                    echo "<script>alert('Insertion failed: " . $conn->error . "');</script>";
                }

                
            }
        }
    } else {
        echo "Failed: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
