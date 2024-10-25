<?php
   include '../connection.php';

   $dfullname = $_POST["deleteFullname"];
   $dpassword = $_POST["deletePassword"];

   // Prepare the select statement
   $dselect = $conn->prepare("SELECT * FROM `computeradmintable` WHERE fullname = ? AND password = ?");
   $dselect->bind_param("ss", $dfullname, $dpassword);  // "ss" means the parameters are strings
   $dselect->execute();
   $dresult = $dselect->get_result();

   // Check if the admin with the given fullname and password exists
   if ($dresult->num_rows > 0) {
       // Prepare the delete statement
       $deleterows = $conn->prepare("DELETE FROM `computeradmintable` WHERE fullname = ? AND password = ?");
       $deleterows->bind_param("ss", $dfullname, $dpassword);

       if ($deleterows->execute()) {
           // Admin deleted successfully
           echo "<script>
                  alert('Admin was deleted!!!');
                  window.location.href = './recordofficeAdmin.php';
                </script>";
           exit();
       } else {
           // Error during deletion
           echo "<script>
                   alert('Connection fail, Please try again!!!');
                   window.location.href = './recordofficeAdmin.php';
                 </script>";
           exit();
       }
   } else {
       // Admin with the given fullname and password not found
       echo "<script>
               alert('Invalid Fullname or Password!');
               window.location.href = './recordofficeAdmin.php';
             </script>";
       exit();
   }
?>
