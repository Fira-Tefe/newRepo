<!-- php code for Upload image -->
<?php
      require './connection.php';
      if(isset($_POST["submit-btn"])){
        $name = $_POST["nameLabel"];
        $phoneNumber = $_POST["mobileNum"];
        $email = $_POST["emailAddress"];
        $unic = $_POST["uniquecode"];

        $selectUnic = "SELECT * FROM `systemadmin` WHERE 1";
        $resultUnic = $conn->query($selectUnic);

        $selectemail = "SELECT * FROM `contactUser` WHERE 1";
        $resultemail = $conn->query($selectemail);

        if($resultUnic->num_rows > 0) {
            while($row = $resultUnic->fetch_assoc()) {
                if($unic == $row["uniqueCode"]){
                  if($resultemail->num_rows > 0) {
                    while($row = $resultemail->fetch_assoc()) {
                        if(($email === $row["email"])) {
                          if($_FILES["imageUploaded"]["error"] == 4){
                            echo "<script> alert('Image does't exist, Please try again!!!'); </script>";
                          }
                          else{
                            $fileName = $_FILES["imageUploaded"]["name"];
                            $fileSize = $_FILES["imageUploaded"]["size"];
                            $tmpName = $_FILES["imageUploaded"]["tmp_name"];

                            $validImageExtension = ['jpg', 'jpeg', 'png'];
                            $imageExtension = explode('.', $fileName);
                            $imageExtension = strtolower(end($imageExtension));
                                if (!in_array($imageExtension, $validImageExtension)){
                                  echo "<script> alert('Invalid Image Extension'); </script>";
                                }
                                else if($fileSize > 100000000){
                                  echo "<script> alert('Image size is too large'); </script>";
                                }
                              else{
                                $newImageName = uniqid() . '.' . $imageExtension;

                                // Ensure the img directory exists and has the right permissions
                                if (!is_dir('img')) {
                                  mkdir('img', 0755, true);
                                }
                    
                                if (move_uploaded_file($tmpName, 'img/' . $newImageName)) {
                                  $query = "INSERT INTO tb_upload(id,name,image,Approval,Decline,email,phonenumber) VALUES('', '$name', '$newImageName','OFF','OFF','$email','$phoneNumber')";
                                  if (mysqli_query($conn, $query)) {
                                    echo "<script>
                                            alert('Sent successfully');
                                            document.location.href = 'index.php';
                                          </script>";
                                  } else {
                                    echo "<script> alert('Database rrror: Could not insert data.'); </script>";
                                  }
                                } else {
                                  echo "<script> alert('Error uploading image'); </script>";
                                }
                              }
                          }
                        }
                       }
                      }
                        else{
                          echo "<script>
                            alert('Use valid Imail, Please try again!!!');
                            document.location.href = 'index.php';
                            </script>";
                          }
                }
                else{
                  echo "<script>
                  alert('You are used invalid Unique Code, Please try again!!!');
                  document.location.href = 'index.php';
                  </script>";
                }
            }
          }
          else{
            echo "<script>
                  alert('System is on Updating, Please try later!!!');
                  document.location.href = 'index.php';
                  </script>";
          }
      }
  ?>
  <!-- php code for type letter -->

  