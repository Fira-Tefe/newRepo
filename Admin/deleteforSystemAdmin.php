<?php
include '../connection.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['deleted'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $deletedStatus = mysqli_real_escape_string($conn, $_POST['deleted']);

        $foundMatch = false;
        $tables = ["admintable", "computeradmintable", "itadmintable"];

        foreach ($tables as $table) {
            $sql = "UPDATE $table SET deleted = '$deletedStatus' WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_affected_rows($conn) > 0) {
                $foundMatch = true;
            }
        }

        foreach ($tables as $table) {
            $deleteSQL = "DELETE FROM $table WHERE deleted = 'ON'";
            $deleteResult = mysqli_query($conn, $deleteSQL);
            if (mysqli_affected_rows($conn) > 0) {
                echo "Deleted Successfully: $table.";
            }
        }

        if (!$foundMatch) {
            echo "No match found for username and password in any table.";
        }
} else {
  echo "Required data missing: username, password, or deleted status not provided.";
}

mysqli_close($conn);
?>
