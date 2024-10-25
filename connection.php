<?php
// Replace the following parameters with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "upload";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
