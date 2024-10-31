<?php
  include '../connection.php';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $past = $_POST["uniqueCode"];
    $new = $_POST["newuniqueCode"];
    $select = "SELECT * FROM `systemadmin` WHERE 1";
        $result1 = $conn->query($select);

        if($result1->num_rows > 0) {
            while($row = $result1->fetch_assoc()) {
                if(($past === $row["uniqueCode"])) {
                    $updateAdmin = $conn->prepare("UPDATE systemadmin SET uniqueCode = '$new' where 1");                            // Execute the update statement
                            if ($updateAdmin->execute()) {
                                echo "<script>alert('Successfully Updated');
                                window.location.href = './recordofficeAdmin.php';</script>";
                                exit();
                            }
                            else{
                                echo "<script>alert('Something is error')</script>";
                                exit();
                            }
                }
                else{
                    echo "<script>alert('Wrong Unique Code');
                        window.location.href = './recordofficeAdmin.php';</script>";
                        exit();
                }
            }
        }
  }
?>