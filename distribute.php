<?php
    session_start();
    include 'connection.php';
    $validUser = true;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $uname = $_POST["username"];
        $pword = $_POST["password"];

        $select = "SELECT * FROM `admintable` WHERE 1";
        $result1 = $conn->query($select);

        $selectComputerAdmin = "SELECT * FROM `computeradmintable` WHERE 1";
        $computerresult1 = $conn->query($selectComputerAdmin);

        $selectItAdmin = "SELECT * FROM `itadmintable` WHERE 1";
        $itresult1 = $conn->query($selectItAdmin);

        $selectMinisterAdmin = "SELECT * FROM `ministeradmin` WHERE 1";
        $ministerResult = $conn->query($selectMinisterAdmin);

        if($result1->num_rows > 0) {
            while($row = $result1->fetch_assoc()) {
                if(($uname === $row["username"]) && ($pword === $row["password"])) {
                    // Set session variables for record office admin
                    $_SESSION['user_role'] = 'record_office_admin';
                    $_SESSION['username'] = $uname;
                    header("Location: ./Admin/recordofficeAdmin.php");
                    $validUser = false;
                    exit();
                }
            }
        }

                if(($uname === "admin") && ($pword === "123")) {
                    // Set session variables for record office admin
                    $_SESSION['user_role'] = 'system_admin';
                    $_SESSION['username'] = "admin";
                    header("Location: ./Admin/recordofficeAdmin.php");
                    $validUser = false;
                    exit();
                }

        if($ministerResult->num_rows > 0) {
            while($row = $ministerResult->fetch_assoc()) {
                if(($uname === $row["username"]) && ($pword === $row["password"])) {
                    // Set session variables for record office admin
                    $_SESSION['user_role'] = 'minister_admin';
                    $_SESSION['username'] = $uname;
                    header("Location: ./Admin/recordofficeAdmin.php");
                    $validUser = false;
                    exit();
                }
            }
        }

        if($computerresult1->num_rows > 0) {
            while($row = $computerresult1->fetch_assoc()) {
                if(($uname === $row["username"]) && ($pword === $row["password"])) {
                    // Set session variables for computer admin
                    $_SESSION['user_role'] = 'computer_admin';
                    $_SESSION['username'] = $uname;
                    header("Location: ./Admin/recordofficeAdmin.php");
                    $validUser = false;
                    exit();
                }
            }
        }

        if($itresult1->num_rows > 0) {
            while($row = $itresult1->fetch_assoc()) {
                if(($uname === $row["username"]) && ($pword === $row["password"])) {
                    // Set session variables for IT admin
                    $_SESSION['user_role'] = 'it_admin';
                    $_SESSION['username'] = $uname;
                    header("Location: ./Admin/recordofficeAdmin.php");
                    $validUser = false;
                    exit();
                }
            }
        }
    }

    if($validUser === true){
        echo "<script>
                    alert('Invalid username or password, Please try again');
                    window.location.href = 'index.php';
              </script>";
        exit(0);
    }
?>
