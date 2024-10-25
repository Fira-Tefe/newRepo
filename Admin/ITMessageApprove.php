<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../connection.php';

if (isset($_POST['id']) && isset($_POST['Approval'])) {
    $id = intval($_POST['id']);
    $approve = ($_POST['Approval'] === 'ON') ? 'ON' : 'OFF';

    // Start transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Update the approval status
        $stmt = $conn->prepare("UPDATE itdepartmenttable SET Approval = ? WHERE id = ?");
        $stmt->bind_param('si', $approve, $id);
        $stmt->execute();

        // Select approved records
        $selectQuery = "SELECT * FROM itdepartmenttable WHERE Approval = 'ON'";
        $selectResult = $conn->query($selectQuery);

        if ($selectResult && $selectResult->num_rows > 0) {
            while ($row = $selectResult->fetch_assoc()) {
                $idrestore = $row['id'];
                $namerestore = $row['name'];
                $imagerestore = $row['image'];
                $departmentrestore = $row['Departments'];
                $emailB = $row['email'];
                $phoneB = $row['phonenumber'];
                $send = 'OFF';

                // Insert into acceptedletters
                $insertStmt = $conn->prepare(
                    "INSERT INTO acceptedletters (id, name, image, Departments, email, phonenumber, send) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                $insertStmt->bind_param(
                    "issssss",
                    $idrestore, $namerestore, $imagerestore,
                    $departmentrestore, $emailB, $phoneB, $send
                );
                $insertStmt->execute();

                // Delete from itdepartmenttable
                $deleteStmt = $conn->prepare("DELETE FROM itdepartmenttable WHERE id = ?");
                $deleteStmt->bind_param("i", $idrestore);
                $deleteStmt->execute();

                // Close statements
                $insertStmt->close();
                $deleteStmt->close();
            }

            // Commit transaction
            $conn->commit();

            echo "<script>
                alert('Records transferred and deleted successfully!');
                window.location.href = './recordOfficeAdmin.php';
            </script>";
        } else {
            throw new Exception('No records with Approval = ON found.');
        }

        $stmt->close();
    } catch (Exception $e) {
        // Roll back on error
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    $conn->close();
} else {
    echo "Invalid request!";
}

?>
