<?php

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = isset($_POST['Fullname']) ? trim($_POST['Fullname']) : '';
    $username = isset($_POST['setUsername']) ? trim($_POST['setUsername']) : '';
    $password = isset($_POST['setPassword']) ? trim($_POST['setPassword']) : '';
    $confirmPassword = isset($_POST['seCpassword']) ? trim($_POST['seCpassword']) : '';
    $position = isset($_POST['position']) ? trim($_POST['position']) : '';

    $validUser = true;

    $select = "SELECT * FROM `admintable`";
    $result1 = $conn->query($select);

    $selectComputerAdmin = "SELECT * FROM `computeradmintable`";
    $computerresult1 = $conn->query($selectComputerAdmin);

    $selectItAdmin = "SELECT * FROM `itadmintable`";
    $itresult1 = $conn->query($selectItAdmin);

    if($result1->num_rows > 0) {
      while($row = $result1->fetch_assoc()) {
          if(($username === $row["username"]) || ($password === $row["password"])) {
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
        if(($username === $row["username"]) || ($password === $row["password"])) {
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
      if(($username === $row["username"]) || ($password === $row["password"])) {
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
    if (empty($fullname) || empty($username) || empty($password) || empty($confirmPassword) || empty($position)) {
        echo "<script>
                alert('All fields are required.');
                window.location.href = './recordOfficeAdmin.php';
            </script>";
        exit;
    }

    if ($password !== $confirmPassword) {
        echo "<script>
                alert('Password Mismatch.');
                window.location.href = './recordOfficeAdmin.php';
            </script>";
        exit;
    }

    $tableMap = [
        "IT Department" => "itadmintable",
        "Computer Department" => "computeradmintable",
        "Record Officer" => "admintable",
        "Third Department" => "thirdadmintable",
        "Fourth Department" => "fourthadmintable"
    ];

    if (!array_key_exists($position, $tableMap)) {
        echo "<script>
                alert('Invalid position selected.');
                window.location.href = './recordOfficeAdmin.php';
            </script>";
        exit;
    }

    $tableName = $tableMap[$position];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO $tableName (fullname, username, password, position, deleted) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $deleted = "OFF";
        $stmt->bind_param("sssss", $fullname, $username, $hashedPassword, $position, $deleted);

        if ($stmt->execute()) {
            echo "<script>
                alert('Admin successfully added to $position.');
                window.location.href = './recordOfficeAdmin.php';
            </script>";
        } else {
            echo "<script>
                alert('Error: ' . $stmt->error);
                window.location.href = './recordOfficeAdmin.php';
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('Error: ' . $conn->error);
                window.location.href = './recordOfficeAdmin.php';
            </script>";
    }
  }
}

$conn->close();
?>
