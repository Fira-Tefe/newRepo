<?php
  include '../connection.php';
  $Fname = $_POST["fullname"];
  $Uname = $_POST["username"];
  $Pword = $_POST["password"];
  $CPword = $_POST["cpassword"];
  $validUser = true;

        $select = "SELECT * FROM `admintable`";
        $result1 = $conn->query($select);

        $selectComputerAdmin = "SELECT * FROM `computeradmintable`";
        $computerresult1 = $conn->query($selectComputerAdmin);

        $selectItAdmin = "SELECT * FROM `itadmintable`";
        $itresult1 = $conn->query($selectItAdmin);

        if($result1->num_rows > 0) {
          while($row = $result1->fetch_assoc()) {
              if(($Uname === $row["username"]) && ($Pword === $row["password"])) {
                echo "<script>
                alert('Change your username or Password please!');
                window.location.href = './recordofficeAdmin.php';
                </script>";
                $validUser = false;
                  exit();
              }
          }
      }

      if($computerresult1->num_rows > 0) {
        while($row = $computerresult1->fetch_assoc()) {
            if(($Uname === $row["username"]) && ($Pword === $row["password"])) {
              echo "<script>
              alert('Change your username or Password please!');
              window.location.href = './recordofficeAdmin.php';
              </script>";
              $validUser = false;
                exit();
            }
        }
    }

    if($itresult1->num_rows > 0) {
      while($row = $itresult1->fetch_assoc()) {
          if(($Uname === $row["username"]) && ($Pword === $row["password"])) {
            echo "<script>
            alert('Change your username or Password please!');
            window.location.href = './recordofficeAdmin.php';
            </script>";
            $validUser = false;
              exit();
          }
      }
  }
  
    if($validUser === true){
          $InsertSql = "Insert into admintable(username,password,fullname,position,deleted) values('$Uname','$Pword','$Fname','Record Officer','OFF'); ";
          if($CPword === $Pword){
            if($conn->query($InsertSql) === true){
              echo "<script>
                    alert('Record Officer Successfully Registred');
                    window.location.href = '../index.php';
                  </script>";
              exit();
            }
            echo "<script>alert('There is no database table!!!');
            window.location.href = './recordofficeAdmin.php.signup';
            </script>";
          }
          else{
            echo "<script>
            alert('Password mismatch, Please try again!!!');
            window.location.href = './recordofficeAdmin.php#signup';
            </script>";
          }
      }
?>