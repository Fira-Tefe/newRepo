<?php
  include '../connection.php';

  // Fetch all rows from tb_upload where Approval is 'ON'
  $selectForDistribute = "SELECT * FROM `tb_upload` WHERE Approval = 'ON'";
  $distributedResult = $conn->query($selectForDistribute);

  if ($distributedResult->num_rows > 0) {
    while ($row = $distributedResult->fetch_assoc()) {
        // Extract row data
        $id = $row["id"];
        $name = $row["name"];
        $image = $row["image"];
        $approval = $row["Approval"];
        $decline = $row["Decline"];
        $department = $row["Departments"];
        $emaild = $row["email"];
        $phonenumberd = $row["phonenumber"];

        // Determine the target department table based on the department
        switch($department) {
            case 'ITDepartment':
                $targetTable = 'itdepartmenttable';
                break;
            case 'ComputerDepartment':
                $targetTable = 'seconddepartmenttable';
                break;
            case 'ThirdDepartment':
                $targetTable = 'thirddepartmenttable';
                break;
            case 'FourthDepartment':
                $targetTable = 'fourthdepartmenttable';
                break;
            case 'FivethDepartment':
                $targetTable = 'fivethdepartmenttable';
                break;
            default:
                $targetTable = null; // No matching department
        }

        // If department matches one of the predefined department names
        if ($targetTable) {
            // Insert the row into the corresponding department table
            $insertToTarget = "INSERT INTO $targetTable (id, name, image, Approval, Decline, Departments, Assign,email,phonenumber)
                               VALUES ('$id', '$name', '$image', 'OFF', '$decline', '$department','OFF','$emaild','$phonenumberd')";
            // Execute the insert query
            if ($conn->query($insertToTarget) === TRUE) {
                // Delete the row from tb_upload after successful insertion
                                    $deleteTbUpload = "DELETE FROM tb_upload WHERE id = '$id'";
                                    if(mysqli_query($conn, $deleteTbUpload)){
                                        // Successfully deleted the row
                                    } else {
                                        echo "<script>
                                                alert('Failed to delete row with id $id from tb_upload');
                                            </script>";
                                    }
            } else {
                echo "Error inserting into $targetTable: " . $conn->error;
            }
        }
    }

    // After processing all rows, redirect
    echo "<script>
              alert('Changes successfully saved.');
              window.location.href = './recordofficeAdmin.php';
          </script>";
  } else {
    echo "<script>
              alert('No rows available your database');
              window.location.href = './recordofficeAdmin.php';
          </script>";
  }

  $conn->close();
?>
