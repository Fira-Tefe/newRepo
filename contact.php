<?php 
    include './connection.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fname = $_POST["fname"];
        $location = $_POST["location"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $description = $_POST["description"];
        $validUser = false;

        $select = "SELECT * FROM `contactUser` WHERE 1";
        $result1 = $conn->query($select);

        if($result1->num_rows > 0) {
            while($row = $result1->fetch_assoc()) {
                if(($email === $row["email"])) {
                    echo "<script>
                        alert('You have already Authenticated, please check your email and Use the Unique Code!!!');
                        window.location.href = 'index.php';
                        </script>";
                    $validUser = true;
                    exit();
                }
            }
        }
    }

    if($validUser === false){
        $InsertSql = "Insert into contactUser(Fullname,location,email,phonenumber,description) values('$fname','$location','$email','$phone','$description'); ";
          if($conn->query($InsertSql) === true){
            $selecta = "SELECT * FROM `systemadmin` WHERE 1";
            $result = $conn->query($selecta);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                     $uniquecode = $row["uniqueCode"];
                    require './Admin/PHPMailer/src/Exception.php';
                    require './Admin/PHPMailer/src/PHPMailer.php';
                    require './Admin/PHPMailer/src/SMTP.php';
                    $sender_name ="Ministry of Innovation and Technology Ethiopia";
                    $sender_email ="firaolteferi90@gmail.com";
                    $recipient_email = $email;
                    $subject = "Authentication Messages";
                    $body = "This is Authentication message from Ministry of Innovation and Technology of Ethiopia,Use MinT unique code = '$uniquecode' ,Thank You for Contact Us!";
                            if(mail($recipient_email,$subject,$body,"From: $sender_name<$sender_email>")){
                                echo "<script>
                                alert('Successed, Check your email, we will sent MinT Unique Code!!!');
                                window.location.href = 'index.php';
                                </script>";
                            exit(0);
                            }
                            else{
                                echo "something went wrong, Related to email address";
                            }
                }
            }
          }
    }
?>