
<?php
    session_start();
    $default_image = 'uploads/profile.jpg'; // Path to the default image
    $profile_image = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : $default_image;

    $computerdefault_image = 'computeruploads/profile.jpg'; // Path to the default image
    $computerprofile_image = isset($_SESSION['computerprofile_image']) ? $_SESSION['computerprofile_image'] : $computerdefault_image;

    $itdefault_image = 'ituploads/profile.jpg'; // Path to the default image
    $itprofile_image = isset($_SESSION['itprofile_image']) ? $_SESSION['itprofile_image'] : $itdefault_image;
    // Determine the user role
    $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pages</title>
    <link rel="stylesheet" href="./switcher.css" />
    <link rel="stylesheet" href="./recordofficeAdmin.css">
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../switcher.css" />
    <link rel="stylesheet" href="../color-1.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../color-1.css" class="alternate-style" title="color-1" disabled/>
    <link rel="stylesheet" href="../color-2.css" class="alternate-style" title="color-2" disabled/>
    <link
      rel="stylesheet"
      href="../color-3.css"
      class="alternate-style"
      title="color-3"
      disabled
    />
    <link
      rel="stylesheet"
      href="../color-4.css"
      class="alternate-style"
      title="color-4"
      disabled
    />
    <link
      rel="stylesheet"
      href="../color-5.css"
      class="alternate-style"
      title="color-5"
      disabled
    />

</head>
<body class="<?php echo $user_role; ?>">
    <?php if ($user_role === 'record_office_admin'): ?>
          <header class="headAdmin">
            <div class="logo">
              <img src="../logo/Ministry_of_Innovation_and_Technology_Ethiopia_removebg_preview.png" alt="">
            </div>
            <div class="box">
              <a href="#profile"><h3 class="navlinks activenav" onclick="convertsection('profile')"><i class='bx bx-home-alt-2'></i>Profile</h3></a>
              <a href="#signup"><h3 class="navlinks" onclick="convertsection('signup')"><i class='bx bx-user-plus'></i>Sign Up</h3></a>
              <a href="#messages"><h3 class="navlinks" onclick="convertsection('messages')"><i class='bx bxs-chat'></i>Messages</h3><span><?php
                          require '../connection.php';
                          // Fetch the number of rows
                          $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tb_upload");
                          $rowCount = mysqli_fetch_assoc($result)['count'];
                          // Close the database connection
                          mysqli_close($conn);
                          // Output the row count
                          echo $rowCount;
                          ?></span></a>
              <a href="#setting"><h3 class="navlinks" onclick="convertsection('setting')"><i class='bx bx-cog'></i>Setting</h3></a>
              <a href="../index.php"><h3><i class='bx bx-log-out'></i>Logout</h3></a>
            </div>
          </header>
        <section class="sections profile activesec" id="profile">
            <div class="hero">
              <div class="card">
                  <h1>Record Officer</h1>
                  <p>@recordoffice</p>
                  <!-- Display current image -->
                  <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" id="profile-pic">
                  <!-- Form for file upload -->
                  <form id="upload-form" action="./upload.php" method="POST" enctype="multipart/form-data">
                      <label for="input-file">Update Image</label>
                      <input type="file" accept=".jpg, .png, .jpeg" id="input-file" name="profile-image">
                      <button type="submit">Save Image</button>
                  </form>
              </div>
            </div>
        </section>

        <section class="sections signup " id="signup">
          <div class="formBox">
            <form action="./conn.php" method="POST" name="signForm" onsubmit="return validateForms(event)">
              <h2>Sign Up</h2>
              <div class="nameDiv">
                  <label for="fullname">Full Name : </label>
                  <input type="text" id="fullname" name="fullname" required>
              </div>
              <div class="usernameDiv">
                  <label for="username">Username : </label>
                  <input type="text" id="username" name="username" required>
              </div>
              <div class="passwordDiv">
                  <label for="password">Password : </label>
                  <input type="password" id="password" name="password" required>
              </div>
              <div class="confirmDiv">
                <label for="cpassword">Confirm Password : </label>
                <input type="password" id="cpassword" name="cpassword" required>
              </div>
              <div class="butnDiv">
                  <button type="submit" name="signup">Sign Up</button>
                  <button type="reset">Reset</button>
              </div>
            </form>
          </div>
        </section>

        <section class="sections messages " id="messages">

        <div class="newBoundary">
         <div class="messagesBanker">
                <h1>
                  New Messages
                </h1>
          </div>
          <div class="savechanges stored">
              <a href="#" id="toggleNewButton">Messages</a>
              <span>
               <?php
                require '../connection.php';
                // Fetch the number of rows
                $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tb_upload");
                $rowCount = mysqli_fetch_assoc($result)['count'];

                // Close the database connection
                mysqli_close($conn);

                // Output the row count
                echo $rowCount;
                ?>
              </span>
          </div>
        </div>
        
          <div id="NewMessagesTable" style="display: none;">
               <div class="savechanges">
                  <a href="./adminDestributer.php">Save Changes</a>
               </div>
               <div class="search">
                  <form action="">
                    <input type="text" name="searchLists" id="searchLists" 
                          placeholder="Search by letter ID" oninput="searchByLetterID(this.value)">
                  </form>
                </div>
                <?php
                  require '../connection.php';
                ?>
                <div class="tableBox" id="tableBox">
                  <table>
                    <tr class="heading">
                      <td><h3>#</h3></td>
                      <td class="Description"><h3>Description</h3></td>
                      <td><h3>Image</h3></td>
                      <td class="Approve"><h3>Send</h3></td>
                      <td class="Decline"><h3>Decline</h3></td>
                      <td class="Department"><h3>Departments</h3></td>
                      <td><h3>Letter ID</h3></td>
                    </tr>
                    <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT * FROM tb_upload ORDER BY id DESC");
                    ?>
                    <?php foreach ($rows as $row) : ?>
                      <tr class="lists" data-row-id="<?php echo $row['id']; ?>">
                        <td class="nlists"><?php echo $i++; ?></td>
                        <td class="dlists"><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                          <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                              alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                              title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
                        </td>
                        <td><h4 onclick="aproveConverter(<?php echo $row['id']; ?>)">
                          <?php echo htmlspecialchars($row["Approval"], ENT_QUOTES, 'UTF-8'); ?></h4></td>
                        <td><h4 onclick="declineConverter(<?php echo $row['id']; ?>)">
                          <?php echo htmlspecialchars($row["Decline"], ENT_QUOTES, 'UTF-8'); ?></h4></td>
                        <td>
                          <h5>
                            <select class="department-select" data-row-id="<?php echo $row['id']; ?>">
                              <option value="ITDepartment" <?php echo $row['Departments'] === 'ITDepartment' ? 'selected' : ''; ?>>IT Department</option>
                              <option value="ComputerDepartment" <?php echo $row['Departments'] === 'ComputerDepartment' ? 'selected' : ''; ?>>Computer Department</option>
                              <option value="ThirdDepartment" <?php echo $row['Departments'] === 'ThirdDepartment' ? 'selected' : ''; ?>>Third Department</option>
                              <option value="FourthDepartment" <?php echo $row['Departments'] === 'FourthDepartment' ? 'selected' : ''; ?>>Fourth Department</option>
                              <option value="FivethDepartment" <?php echo $row['Departments'] === 'FivethDepartment' ? 'selected' : ''; ?>>Fiveth Department</option>
                            </select>
                          </h5>
                        </td>
                        <td class="nlists"><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
              </div>

          <div class="boundary">
             <div class="messagesBanker">
                <h1>
                  Temporary Messages
                </h1>
              </div>
          <div class="savechanges stored">
              <a href="#" id="toggleAcceptedButton">Accepted Messages</a>
              <span>
               <?php
                require '../connection.php';
                // Fetch the number of rows
                $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM acceptedletters");
                $rowCount = mysqli_fetch_assoc($result)['count'];

                // Close the database connection
                mysqli_close($conn);

                // Output the row count
                echo $rowCount;
                ?>
              </span>
          </div>
          <?php
            include "../connection.php";
          ?>
          <div class="tableBox" id="acceptedMessagesTable" style="display: none;">
                <div class="search approve">
                  <form action="">
                    <input type="text"
                          placeholder="Search by letter ID">
                  </form>
                </div>
                <table>
                <tr class="heading">
                      <td><h3>#</h3></td>
                      <td class="Description"><h3>Description</h3></td>
                      <td><h3>Image</h3></td>
                      <td><h3>Letter ID</h3></td>
                      <td><h3>From</h3></td>
                      <td><h3>Email</h3></td>
                      <td><h3>Phone number</h3></td>
                      <td><h3>Send</h3></td>
                    </tr>
                    <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT * FROM acceptedletters WHERE 1 ORDER BY id DESC");
                    foreach ($rows as $row) : ?>
                      <tr class="lists">
                      <td class="nlists"><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                          <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                              alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                              title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row["Departments"], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td><?php echo htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row["phonenumber"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <h4
                              class="<?php echo $row["send"] === 'ON' ? 'on-status' : 'off-status'; ?>" 
                              data-Send-id="<?php echo $row['id']; ?>"
                              onclick="RecordOfficerAcceptedSendMessage(<?php echo $row['id']; ?>)">
                              <?php echo htmlspecialchars($row["send"], ENT_QUOTES, 'UTF-8'); ?>
                            </h4>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>

          <div class="savechanges stored">
              <a href="#" id="toggleRejectedButton">Rejected Messages</a>
              <span>
               <?php
                require '../connection.php';
                // Fetch the number of rows
                $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM rejectedmessages");
                $rowCount = mysqli_fetch_assoc($result)['count'];

                // Close the database connection
                mysqli_close($conn);

                // Output the row count
                echo $rowCount;
                ?>
              </span>
          </div>
          <?php
            include "../connection.php";
          ?>
          <div class="tableBox" id="RegectedMessagesTable" style="display: none;">
                <div class="search approve">
                  <form action="">
                    <input type="text"
                          placeholder="Search by letter ID">
                  </form>
                </div>
                <table>
                  <tr class="heading">
                    <td><h3>#</h3></td>
                    <td class="Description"><h3>Description</h3></td>
                    <td><h3>Image</h3></td>
                    <td><h3>From</h3></td>
                    <td><h3>Email</h3></td>
                    <td><h3>Phone number</h3></td>
                    <td><h3>Restore</h3></td>
                    <td><h3>Decline</h3></td>
                    <td><h3>Letter ID</h3></td>
                  </tr>
                  <?php
                  $i = 1;
                  // Query the `rejectedmessages` table to retrieve the rows
                  $rows = mysqli_query($conn, "SELECT * FROM rejectedmessages ORDER BY id DESC");
                  foreach ($rows as $row) : ?>
                    <tr class="lists">
                      <td class="nlists"><?php echo $i++; ?></td>
                      <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td>
                        <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                            alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                            title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
                      </td>
                      <td><?php echo htmlspecialchars($row["Departments"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td><?php echo htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td><?php echo htmlspecialchars($row["phonenumber"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td>
                        <h4 data-restore-id="<?php echo $row['id']; ?>" class="toggle-restore">
                          <?php echo htmlspecialchars($row["Restore"], ENT_QUOTES, 'UTF-8'); ?>
                        </h4>
                      </td>
                      <td>
                        <h4 data-decline-id="<?php echo $row['id']; ?>" class="toggle-decline">
                          <?php echo htmlspecialchars($row["Decline"], ENT_QUOTES, 'UTF-8'); ?>
                        </h4>
                      </td>
                      <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </table>
                </div>
              <div class="messagesBanker">
                <h1>
                  Stored Messages
                </h1>
              </div>
                <!-- this the storage table -->
          <div class="savechanges stored">
              <a href="#" id="toggleApproveButton">Approved Messages</a>
          </div>
          
          <div class="tableBox" id="approvedMessagesTable" style="display: none;">
          <div class="search approve" >
                  <form action="">
                    <input type="text"
                          placeholder="Search by letter ID">
                  </form>
          </div>
              <table>
                  <tr class="heading">
                      <th><h3>#</h3></th>
                      <th class="Description"><h3>Description</h3></th>
                      <th><h3>Image</h3></th>
                      <th class="Department"><h3>Departments</h3></th>
                      <th><h3>Letter ID</h3></th>
                      <th><h3>Email Address</h3></th>
                  </tr>
                  <?php
                  $i = 1;
                  $rows = mysqli_query($conn, "SELECT * FROM approvestoreRecords WHERE Approval = 'ON' ORDER BY id DESC");
                  foreach ($rows as $row) : ?>
                      <tr class="lists">
                          <td class="nlists"><?php echo $i++; ?></td>
                          <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td>
                              <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                                  alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                  title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
                          </td>
                          <td><h5><?php echo htmlspecialchars($row["Departments"], ENT_QUOTES, 'UTF-8'); ?></h5></td>
                          <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></td>
                      </tr>
                  <?php endforeach; ?>
              </table>
          </div>

                <div class="savechanges stored">
                  <a href="#" id="toggleButton">Declined Messages</a>
                </div>
                <div class="tableBox" id="declinedMessagesTable" style="display: none;">
                <div class="search approve">
                  <form action="">
                    <input type="text"
                          placeholder="Search by letter ID">
                  </form>
                </div>
                  <table>
                    <tr class="heading">
                      <td><h3>#</h3></td>
                      <td class="Description"><h3>Description</h3></td>
                      <td><h3>Image</h3></td>
                      <td class="Decline"><h3>Restore</h3></td>
                      <td><h3>Letter ID</h3></td>
                      <td><h3>Email Address</h3></td>
                    </tr>
                    <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT * FROM storerecords WHERE Decline = 'ON' ORDER BY id DESC");
                    foreach ($rows as $row) : ?>
                      <tr class="lists">
                      <td class="nlists"><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                          <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                              alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                              title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
                        </td>
                        <td>
                          <h4
                            class="<?php echo $row["Restore"] === 'ON' ? 'on-status' : 'off-status'; ?>" 
                            data-restore-id="<?php echo $row['id']; ?>"
                            onclick="toggleRestoreStatus(<?php echo $row['id']; ?>)">
                            <?php echo htmlspecialchars($row["Restore"], ENT_QUOTES, 'UTF-8'); ?>
                          </h4>
                        </td>

                        <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
                </div>
        </section>
        <section class="sections setting " id="setting">
            <div class="headingSet">
              <h4 class="navSet active" onclick="changeSet('rename')">Edit Admin</h4>
              <h4 class="navSet" onclick="changeSet('delete')">Delete Admin</h4>
              <h4 class="navSet" onclick="changeSet('selectAll')">All Admin lists <span>
                                                                                    <?php
                                                                                      require '../connection.php';
                                                                                      // Fetch the number of rows
                                                                                      $resultA = mysqli_query($conn, "SELECT COUNT(*) as count FROM admintable WHERE fullname!=''");
                                                                                      $rowCountA = mysqli_fetch_assoc($resultA)['count'];

                                                                                      // Close the database connection
                                                                                      mysqli_close($conn);

                                                                                      // Output the row count
                                                                                      echo $rowCountA;
                                                                                    ?>
                                                                                  </span>
              </h4>
            </div>
            <div class="setLists rename activeSet" id="rename">
                  <h3>Rename Admin</h3>
              <form action="./recordOfficeRenameSetting.php" method="POST">
                  <div class="previousFullname">
                    <label for="previousFullname">Enter Previous Fullname :</label>
                    <input type="text" id="previousFullname" name="previousFullname" required>
                  </div>
                  <div class="previousPassword">
                    <label for="previousPassword">Enter Previous Password :</label>
                    <input type="text" id="previousPassword" name="previousPassword" required>
                  </div>
                  <div class="newFullname">
                    <label for="newFullname">Enter New Fullname : </label>
                    <input type="text" id="newFullname" name="newFullname" required>
                  </div>
                  <div class="setUser">
                    <label for="setUsername">Enter New Username : </label>
                    <input type="text" id="setUsername" name="setUsername" required>
                  </div>
                  <div class="setPassword">
                    <label for="setPassword">Enter New Password : </label>
                    <input type="password" id="setPassword" name="setPassword" required>
                  </div>
                  <div class="seCpassword">
                    <label for="seCpassword">Confirm Your Password : </label>
                    <input type="password" id="seCpassword" name="seCpassword" required>
                  </div>
                  <div class="setButton">
                    <button type="submit">Rename</button>
                    <button type="reset">Reset</button>
                  </div>
              </form>
             </div>
            <div class="setLists delete" id="delete">
              <h3>Delete Admin</h3>
              <form action="./recordOfficerSetting.php" method="POST">
                <div class="deleteName">
                  <label for="deleteFullname">Enter Fullname :</label>
                  <input type="text" id="deleteFullname" name="deleteFullname" required>
                </div>
                <div class="deletePassword">
                  <label for="deletePassword">Enter Password :</label>
                  <input type="password" id="deletePassword" name="deletePassword" required>
                </div>
                <div class="deleteBtn">
                  <button type="submit">Delete</button>
                </div>
              </form>
            </div>
            <div class="setLists selectAll" id="selectAll">
            <h3>List of Admins</h3>
            <table class="selectTable">
                <?php
                  require '../connection.php';
                  $i = 1;
                  // Fetch data from admintable
                  $selectRows = mysqli_query($conn, "SELECT * FROM admintable WHERE fullname!=''");

                  // Check if there are any rows returned
                  if(mysqli_num_rows($selectRows) > 0) :
                ?>
                    <tr>
                      <th class="Cnumber">#</th>
                      <th class="Cfullname">Fullname</th>
                      <th class="Cusername">Username</th>
                    </tr>
                    
                    <!-- Loop through the fetched rows -->
                    <?php while ($row = mysqli_fetch_assoc($selectRows)) : ?>
                    <tr>
                      <td class="Sno"><?php echo $i++; ?></td>
                      <td class="Snm"><?php echo htmlspecialchars($row["fullname"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td class="Sun"><?php echo htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    
                <?php else : ?>
                    <tr>
                      <td colspan="3">No admins found.</td>
                    </tr>
                <?php endif; ?>

            </table>
            </div>
        </section>
    <?php elseif ($user_role === 'system_admin'): ?>
      <header class="headAdmin">
            <div class="logo">
              <img src="../logo/Ministry_of_Innovation_and_Technology_Ethiopia_removebg_preview.png" alt="">
            </div>
            <div class="box">
              <a href="#profile"><h3 class="navlinks activenav" onclick="convertsection('profile')"><i class='bx bx-home-alt-2'></i>Profile</h3></a>
              <a href="#setting"><h3 class="navlinks" onclick="convertsection('setting')"><i class='bx bx-cog'></i>Manage All</h3></a>
              <a href="../index.php"><h3><i class='bx bx-log-out'></i>Logout</h3></a>
            </div>
          </header>

      <section class="sections setting " id="setting">
                <div class="savechanges stored">
                  <a href="#" id="toggleButton">All Lists</a>
                </div>
                <div class="tableBox" id="declinedMessagesTable" style="display: none;">
                <div class="cssadmin">
                <div class="search">
                  <form action="">
                    <input type="text"
                          placeholder="Search by Position">
                  </form>
                </div>
                <div class="manageTable">
                  <table class="admintableBox managelists">
                      <tr>
                        <td class="head"><h3>#</h3></td>
                        <td class="head"><h3>Full Name</h3></td>
                        <td class="head"><h3>Username</h3></td>
                        <td class="head"><h3>Password</h3></td>
                        <td class="head"><h3>Position</h3></td>
                        <td class="head"><h3>Delete</h3></td>
                      </tr>
                      <?php
                        include '../connection.php';
                        $i = 1;
                        $selectRows = mysqli_query($conn, "SELECT * FROM admintable WHERE 1");
                        if(mysqli_num_rows($selectRows) > 0) :
                      ?>
                     <?php while ($row = mysqli_fetch_assoc($selectRows)) : ?>
                        <tr class="lists">
                          <td class="nlists"><?php echo $i++; ?></td>
                          <td><?php echo htmlspecialchars($row["fullname"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["password"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["position"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td></td>
                        </tr>
                        <?php endwhile; ?>
                          <?php else : ?>
                            <tr>
                              <td colspan="3">No admins found.</td>
                            </tr>
                      <?php endif; ?>

                      <?php
                        include '../connection.php';
                        $selectRows = mysqli_query($conn, "SELECT * FROM computeradmintable WHERE 1");
                        if(mysqli_num_rows($selectRows) > 0) :
                      ?>
                     <?php while ($row = mysqli_fetch_assoc($selectRows)) : ?>
                        <tr class="lists">
                          <td class="nlists"><?php echo $i++; ?></td>
                          <td><?php echo htmlspecialchars($row["fullname"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["password"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["position"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td></td>
                        </tr>
                        <?php endwhile; ?>
                          <?php else : ?>
                            <tr>
                              <td colspan="3">No admins found.</td>
                            </tr>
                      <?php endif; ?>


                      <?php
                        include '../connection.php';
                        $selectRows = mysqli_query($conn, "SELECT * FROM itadmintable WHERE 1");
                        if(mysqli_num_rows($selectRows) > 0) :
                      ?>
                     <?php while ($row = mysqli_fetch_assoc($selectRows)) : ?>
                        <tr class="lists">
                          <td class="nlists"><?php echo $i++; ?></td>
                          <td><?php echo htmlspecialchars($row["fullname"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["password"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["position"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td></td>
                        </tr>
                        <?php endwhile; ?>
                          <?php else : ?>
                            <tr>
                              <td colspan="3">No admins found.</td>
                            </tr>
                      <?php endif; ?>
                    </table>
                  </div>
                 </div>
             </div>

             <div class="savechanges stored">
                  <a href="#" id="">Edit Lists</a>
              </div>

              <div class="savechanges stored">
                  <a href="#" id="">Sign up</a>
              </div>

              <div class="savechanges stored">
              <a href="#" id="toggleAcceptedButton">Contact Users</a>
              </div>

              <div class="contact_table" id="acceptedMessagesTable" style="display: none;">
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur enim illum excepturi sunt in eaque possimus nulla cumque sint. Eius.</p>
              </div>

        </section>
    <?php elseif ($user_role === 'minister_admin'): ?>
          <header class="headAdmin">
              <div class="logo">
                <img src="../logo/Ministry_of_Innovation_and_Technology_Ethiopia_removebg_preview.png" alt="">
              </div>
              <div class="box">
                <a href="#profile"><h3 class="navlinks activenav" onclick="convertsection('profile')"><i class='bx bx-home-alt-2'></i>Profile</h3></a>
                <a href="#messages"><h3 class="navlinks" onclick="convertsection('messages')"><i class='bx bxs-chat'></i>Messages</h3><span><?php
                            require '../connection.php';
                            // Fetch the number of rows
                            $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM ministerMessages");
                            $rowCount = mysqli_fetch_assoc($result)['count'];

                            // Close the database connection
                            mysqli_close($conn);

                            // Output the row count
                            echo $rowCount;
                            ?></span></a>
                <a href="#setting"><h3 class="navlinks" onclick="convertsection('setting')"><i class='bx bx-cog'></i>Setting</h3></a>
                <a href="../index.php"><h3><i class='bx bx-log-out'></i>Logout</h3></a>
              </div>
          </header>
          <section class="sections profile activesec" id="profile">
            <div class="hero">
              <div class="card">
                  <h1>Mininter Admin</h1>
                  <p>@minister</p>
                  <!-- Display current image -->
                  <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" id="profile-pic">
                  <!-- Form for file upload -->
                  <form id="upload-form" action="./upload.php" method="POST" enctype="multipart/form-data">
                      <label for="input-file">Update Image</label>
                      <input type="file" accept=".jpg, .png, .jpeg" id="input-file" name="profile-image">
                      <button type="submit">Save Image</button>
                  </form>
              </div>
            </div>
          </section>
          <section class="sections setting " id="setting">
            <div class="headingSet">
              <h4 class="navSet active" onclick="changeSet('rename')">Edit Admin</h4>
            </div>
            <div class="setLists rename activeSet" id="rename">
                  <h3>Edit Your Info</h3>
              <form action="./recordOfficeRenameSetting.php" method="POST">
                  <div class="previousFullname">
                    <label for="previousFullname">Enter Previous Fullname :</label>
                    <input type="text" id="previousFullname" name="previousFullname" required>
                  </div>
                  <div class="previousPassword">
                    <label for="previousPassword">Enter Previous Password :</label>
                    <input type="text" id="previousPassword" name="previousPassword" required>
                  </div>
                  <div class="newFullname">
                    <label for="newFullname">Enter New Fullname : </label>
                    <input type="text" id="newFullname" name="newFullname" required>
                  </div>
                  <div class="setUser">
                    <label for="setUsername">Enter New Username : </label>
                    <input type="text" id="setUsername" name="setUsername" required>
                  </div>
                  <div class="setPassword">
                    <label for="setPassword">Enter New Password : </label>
                    <input type="password" id="setPassword" name="setPassword" required>
                  </div>
                  <div class="seCpassword">
                    <label for="seCpassword">Confirm Your Password : </label>
                    <input type="password" id="seCpassword" name="seCpassword" required>
                  </div>
                  <div class="setButton">
                    <button type="submit">Rename</button>
                    <button type="reset">Reset</button>
                  </div>
              </form>
             </div>
          </section>
    <?php elseif ($user_role === 'computer_admin'): ?>
      <header class="headAdmin">
            <div class="logo">
              <img src="../logo/Ministry_of_Innovation_and_Technology_Ethiopia_removebg_preview.png" alt="">
            </div>
            <div class="box">
              <a href="#profile"><h3 class="navlinks activenav" onclick="convertsection('profile')"><i class='bx bx-home-alt-2'></i>Profile</h3></a>
              <a href="#signup"><h3 class="navlinks" onclick="convertsection('signup')"><i class='bx bx-user-plus'></i>Sign Up</h3></a>
              <a href="#messages"><h3 class="navlinks" onclick="convertsection('messages')"><i class='bx bxs-chat'></i>Messages</h3><span><?php
                          require '../connection.php';
                          // Fetch the number of rows
                          $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM seconddepartmenttable");
                          $rowCount = mysqli_fetch_assoc($result)['count'];

                          // Close the database connection
                          mysqli_close($conn);

                          // Output the row count
                          echo $rowCount;
                          ?></span></a>
              <a href="#setting"><h3 class="navlinks" onclick="convertsection('setting')"><i class='bx bx-cog'></i>Setting</h3></a>
              <a href="../index.php"><h3><i class='bx bx-log-out'></i>Logout</h3></a>
            </div>
          </header>
          <section class="sections profile activesec" id="profile">
              <div class="hero">
                  <div class="card">
                      <h1>Computer Admin</h1>
                      <p>@computeradmin</p>
                      <!-- Display current image -->
                      <img src="<?php echo htmlspecialchars($_SESSION['computerprofile_image'] ?? $computerdefault_image); ?>" alt="Computer Profile Image" id="computerprofile-pic">
                      <!-- Form for file upload -->
                      <form id="upload-form" action="./computerupload.php" method="POST" enctype="multipart/form-data">
                          <label for="computerinput-file">Update Image</label>
                          <input type="file" accept=".jpg, .png, .jpeg" id="computerinput-file" name="computerprofile_image">
                          <button type="submit">Save Image</button>
                      </form>
                  </div>
              </div>
          </section>


        <section class="sections signup " id="signup">
          <div class="formBox">
            <form action="./computerconn.php" method="POST" name="signForm" onsubmit="return validateForms(event)">
              <h2>Sign Up</h2>
              <div class="nameDiv">
                  <label for="fullname">Full Name : </label>
                  <input type="text" id="fullname" name="fullname" required>
              </div>
              <div class="usernameDiv">
                  <label for="username">Username : </label>
                  <input type="text" id="username" name="username" required>
              </div>
              <div class="passwordDiv">
                  <label for="password">Password : </label>
                  <input type="password" id="password" name="password" required>
              </div>
              <div class="confirmDiv">
                <label for="cpassword">Confirm Password : </label>
                <input type="password" id="cpassword" name="cpassword" required>
              </div>
              <div class="butnDiv">
                  <button type="submit" name="signup">Sign Up</button>
                  <button type="reset">Reset</button>
              </div>
            </form>
          </div>
        </section>

        <section class="sections messages " id="messages">
        <?php
          require '../connection.php';
        ?>
               <div class="savechanges">
                  <a href="#">Save Changes</a>
               </div>
        <div class="tableBox">
              <table>
                  <tr class="heading">
                    <td><h3>#</h3></td>
                    <td clas="Description"><h3>Description</h3></td>
                    <td><h3>Image</h3></td>
                    <td clas="Department"><h3>Departments</h3></td>
                    <td><h3>Letter ID</h3></td>
                    <td class="Assign"><h3>Assign</h3></td>
                    <td clas="Decline"><h3>Decline</h3></td>
                  </tr>
                <?php
                $i = 1;
                $rows = mysqli_query($conn, "SELECT * FROM seconddepartmenttable ORDER BY id DESC");
                ?>

              <!-- Inside the foreach loop -->
                <?php foreach ($rows as $row) : ?>
                <tr class="lists" data-row-id="<?php echo $row['id']; ?>">
                    <td class="nlists"><?php echo $i++; ?></td>
                    <td class="dlists"><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
                    </td>
                    <td><h5><?php echo htmlspecialchars($row["Departments"], ENT_QUOTES, 'UTF-8'); ?></h5></td>
                    <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><h4><?php echo htmlspecialchars($row["Assign"], ENT_QUOTES, 'UTF-8'); ?></h4></td>
                    <td><h4><?php echo htmlspecialchars($row["Decline"], ENT_QUOTES, 'UTF-8'); ?></h4></td>
                </tr>
                <?php endforeach; ?>
              </table>
          </div>
        </section>
        <section class="sections setting " id="setting">
            <div class="headingSet">
              <h4 class="navSet active" onclick="changeSet('rename')">Edit Admin</h4>
              <h4 class="navSet" onclick="changeSet('delete')">Delete Admin</h4>
              <h4 class="navSet" onclick="changeSet('selectAll')">All Admin lists <span>
                                                                                    <?php
                                                                                      require '../connection.php';
                                                                                      // Fetch the number of rows
                                                                                      $resultA = mysqli_query($conn, "SELECT COUNT(*) as count FROM computeradmintable WHERE fullname!=''");
                                                                                      $rowCountA = mysqli_fetch_assoc($resultA)['count'];

                                                                                      // Close the database connection
                                                                                      mysqli_close($conn);

                                                                                      // Output the row count
                                                                                      echo $rowCountA;
                                                                                    ?>
                                                                                  </span>
              </h4>
            </div>
            <div class="setLists rename activeSet" id="rename">
                  <h3>Rename Admin</h3>
              <form action="./computerAdminRename.php" method="POST">
                  <div class="previousFullname">
                    <label for="previousFullname">Enter Previous Fullname :</label>
                    <input type="text" id="previousFullname" name="previousFullname" required>
                  </div>
                  <div class="previousPassword">
                    <label for="previousPassword">Enter Previous Password :</label>
                    <input type="text" id="previousPassword" name="previousPassword" required>
                  </div>
                  <div class="newFullname">
                    <label for="newFullname">Enter New Fullname : </label>
                    <input type="text" id="newFullname" name="newFullname" required>
                  </div>
                  <div class="setUser">
                    <label for="setUsername">Enter New Username : </label>
                    <input type="text" id="setUsername" name="setUsername" required>
                  </div>
                  <div class="setPassword">
                    <label for="setPassword">Enter New Password : </label>
                    <input type="password" id="setPassword" name="setPassword" required>
                  </div>
                  <div class="seCpassword">
                    <label for="seCpassword">Confirm Your Password : </label>
                    <input type="password" id="seCpassword" name="seCpassword" required>
                  </div>
                  <div class="setButton">
                    <button type="submit">Rename</button>
                    <button type="reset">Reset</button>
                  </div>
              </form>
             </div>
            <div class="setLists delete" id="delete">
              <h3>Delete Admin</h3>
              <form action="./computerAdminDelete.php" method="POST">
                <div class="deleteName">
                  <label for="deleteFullname">Enter Fullname :</label>
                  <input type="text" id="deleteFullname" name="deleteFullname" required>
                </div>
                <div class="deletePassword">
                  <label for="deletePassword">Enter Password :</label>
                  <input type="password" id="deletePassword" name="deletePassword" required>
                </div>
                <div class="deleteBtn">
                  <button type="submit">Delete</button>
                </div>
              </form>
            </div>
            <div class="setLists selectAll" id="selectAll">
            <h3>List of Admins</h3>
            <table class="selectTable">
                <?php
                  require '../connection.php';
                  $i = 1;
                  // Fetch data from admintable
                  $selectRows = mysqli_query($conn, "SELECT * FROM computeradmintable WHERE fullname!=''");

                  // Check if there are any rows returned
                  if(mysqli_num_rows($selectRows) > 0) :
                ?>
                    <tr>
                      <th class="Cnumber">#</th>
                      <th class="Cfullname">Fullname</th>
                      <th class="Cusername">Username</th>
                    </tr>
                    
                    <!-- Loop through the fetched rows -->
                    <?php while ($row = mysqli_fetch_assoc($selectRows)) : ?>
                    <tr>
                      <td class="Sno"><?php echo $i++; ?></td>
                      <td class="Snm"><?php echo htmlspecialchars($row["fullname"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td class="Sun"><?php echo htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    
                <?php else : ?>
                    <tr>
                      <td colspan="3">No admins found.</td>
                    </tr>
                <?php endif; ?>

            </table>
            </div>
        </section>
    <?php elseif ($user_role === 'it_admin'): ?>
      <header class="headAdmin">
            <div class="logo">
              <img src="../logo/Ministry_of_Innovation_and_Technology_Ethiopia_removebg_preview.png" alt="">
            </div>
            <div class="box">
              <a href="#profile"><h3 class="navlinks activenav" onclick="convertsection('profile')"><i class='bx bx-home-alt-2'></i>Profile</h3></a>
              <a href="#signup"><h3 class="navlinks" onclick="convertsection('signup')"><i class='bx bx-user-plus'></i>Sign Up</h3></a>
              <a href="#messages"><h3 class="navlinks" onclick="convertsection('messages')"><i class='bx bxs-chat'></i>Messages</h3><span><?php
                          require '../connection.php';
                          // Fetch the number of rows
                          $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM itdepartmenttable");
                          $rowCount = mysqli_fetch_assoc($result)['count'];

                          // Close the database connection
                          mysqli_close($conn);

                          // Output the row count
                          echo $rowCount;
                          ?></span></a>
              <a href="#setting"><h3 class="navlinks" onclick="convertsection('setting')"><i class='bx bx-cog'></i>Setting</h3></a>
              <a href="../index.php"><h3><i class='bx bx-log-out'></i>Logout</h3></a>
            </div>
          </header>
          <section class="sections profile activesec" id="profile">
          <div class="hero">
                  <div class="card">
                      <h1>IT Admin</h1>
                      <p>@itadmin</p>
                      <!-- Display current image -->
                      <img src="<?php echo htmlspecialchars($_SESSION['itprofile_image'] ?? $itdefault_image); ?>" alt="IT Profile Image" id="itprofile-pic">
                      <!-- Form for file upload -->
                      <form id="upload-form" action="./itupload.php" method="POST" enctype="multipart/form-data">
                          <label for="itinput-file">Update Image</label>
                          <input type="file" accept=".jpg, .png, .jpeg" id="itinput-file" name="itprofile_image">
                          <button type="submit">Save Image</button>
                      </form>
                  </div>
                 </div>
        </section>

        <section class="sections signup " id="signup">
          <div class="formBox">
            <form action="./itconn.php" method="POST" name="signForm" onsubmit="return validateForms(event)">
              <h2>Sign Up</h2>
              <div class="nameDiv">
                  <label for="fullname">Full Name : </label>
                  <input type="text" id="fullname" name="fullname" required>
              </div>
              <div class="usernameDiv">
                  <label for="username">Username : </label>
                  <input type="text" id="username" name="username" required>
              </div>
              <div class="passwordDiv">
                  <label for="password">Password : </label>
                  <input type="password" id="password" name="password" required>
              </div>
              <div class="confirmDiv">
                <label for="cpassword">Confirm Password : </label>
                <input type="password" id="cpassword" name="cpassword" required>
              </div>
              <div class="butnDiv">
                  <button type="submit" name="signup">Sign Up</button>
                  <button type="reset">Reset</button>
              </div>
            </form>
          </div>
        </section>

        <section class="sections messages " id="messages">
        <div class="messagesBanker">
          <h1>
            New Messages
          </h1>
        </div>
        <div class="savechanges stored">
            <a href="#" id="itNewMessages">New Messages</a>
            <span>
            <?php
                require '../connection.php';
                // Fetch the number of rows
                $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM itdepartmenttable");
                $rowCount = mysqli_fetch_assoc($result)['count'];

                // Close the database connection
                mysqli_close($conn);

                // Output the row count
                echo $rowCount;
                ?>
            </span>
        </div>

         <div class="new" id="itNewMessageTable" style="display: none;">
               <div class="savechanges">
                  <a href="./recordofficeAdmin.php">Save Changes</a>
               </div>
               <?php
                  require '../connection.php';
                ?>
               <div class="tableBox">
                    <table>
                      <tr class="heading">
                          <td><h3>#</h3></td>
                          <td class="Description"><h3>Description</h3></td>
                          <td><h3>Image</h3></td>
                          <td class="Department"><h3>Departments</h3></td>
                          <td><h3>Letter ID</h3></td>
                          <td class="Assign"><h3>Approve</h3></td>
                          <td class="Approve"><h3>Decline</h3></td>
                      </tr>

                      <?php
                      $i = 1;
                      $rows = mysqli_query($conn, "SELECT * FROM itdepartmenttable ORDER BY id DESC");
                      foreach ($rows as $row):
                      ?>
                      <tr class="lists" data-row-id="<?php echo $row['id']; ?>">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td>
                              <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                                  alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>">
                          </td>
                          <td><?php echo htmlspecialchars($row["Departments"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td>
                            <h4
                              class="<?php echo $row["Approval"] === 'ON' ? 'on-status' : 'off-status'; ?>" 
                              data-Approve-id="<?php echo $row['id']; ?>"
                              onclick="ITtoggleApproveStatus(<?php echo $row['id']; ?>)">
                              <?php echo htmlspecialchars($row["Approval"], ENT_QUOTES, 'UTF-8'); ?>
                            </h4>
                          </td>
                          <td>
                            <h4
                              class="<?php echo $row["Decline"] === 'ON' ? 'on-status' : 'off-status'; ?>" 
                              data-restore-id="<?php echo $row['id']; ?>"
                              onclick="ITtoggleRestore(<?php echo $row['id']; ?>)">
                              <?php echo htmlspecialchars($row["Decline"], ENT_QUOTES, 'UTF-8'); ?>
                            </h4>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  </table>
              </div>
            </div>

            <div class="messagesBanker">
              <h1>
                Approved Messages
              </h1>
            </div>

            
            <div class="savechanges stored">
                  <a href="#" id="toggleButtonDone">New Messages</a>
                    <span>
                      <?php
                          require '../connection.php';
                          // Fetch the number of rows
                          $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM itacceptedsend");
                          $rowCount = mysqli_fetch_assoc($result)['count'];

                          // Close the database connection
                          mysqli_close($conn);

                          // Output the row count
                          echo $rowCount;
                          ?>
                  </span>
            </div>

            <div id="DoneMessagesTable" style="display: none;">
            <div class="savechanges">
                  <a href="./recordofficeAdmin.php">Save Changes</a>
               </div>
               <?php
                  require '../connection.php';
                ?>
               <div class="tableBox">
                    <table>
                      <tr class="heading">
                          <td><h3>#</h3></td>
                          <td class="Description"><h3>Description</h3></td>
                          <td><h3>Image</h3></td>
                          <td class="Department"><h3>Departments</h3></td>
                          <td><h3>Letter ID</h3></td>
                          <td class="Assign"><h3>Assign</h3></td>
                      </tr>

                      <?php
                      $i = 1;
                      $rows = mysqli_query($conn, "SELECT * FROM itacceptedsend ORDER BY id DESC");
                      foreach ($rows as $row):
                      ?>
                      <tr class="lists" data-row-id="<?php echo $row['id']; ?>">
                          <td><?php echo $i++; ?></td>
                          <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td>
                              <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                                  alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>">
                          </td>
                          <td><?php echo htmlspecialchars($row["Departments"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td>
                            <h4>
                              <?php echo htmlspecialchars($row["Assign"], ENT_QUOTES, 'UTF-8'); ?>
                            </h4>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  </table>
              </div>
            </div>

            <div class="messagesBanker">
              <h1>
                Stored Messages
              </h1>
            </div>
                <div class="savechanges stored">
                  <a href="#" id="">Assigned Messages</a>
                </div>
                <div class="savechanges stored">
                  <a href="#" id="toggleButton">Declined Messages</a>
                </div>

                <div class="tableBox" id="declinedMessagesTable" style="display: none;">
                <div class="search approve">
                  <form action="">
                    <input type="text"
                          placeholder="Search by letter ID">
                  </form>
                </div>
                  <table>
                    <tr class="heading">
                      <td><h3>#</h3></td>
                      <td class="Description"><h3>Description</h3></td>
                      <td><h3>Image</h3></td>
                      <td><h3>Letter ID</h3></td>
                      <td class="Decline"><h3>Restore</h3></td>
                      <td><h3>Email Address</h3></td>
                    </tr>
                    <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT * FROM ITstorerecords WHERE Decline = 'ON' ORDER BY id DESC");
                    foreach ($rows as $row) : ?>
                      <tr class="lists">
                      <td class="nlists"><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                          <img src="../img/<?php echo htmlspecialchars($row["image"], ENT_QUOTES, 'UTF-8'); ?>" 
                              alt="Image of <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                              title="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>">
                        </td>
                        <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                          <h4
                            class="<?php echo $row["Restore"] === 'ON' ? 'on-status' : 'off-status'; ?>" 
                            data-restore-id="<?php echo $row['id']; ?>"
                            onclick="ITtoggleRestoreStatus(<?php echo $row['id']; ?>)">
                            <?php echo htmlspecialchars($row["Restore"], ENT_QUOTES, 'UTF-8'); ?>
                          </h4>
                        </td>
                        <td><?php echo htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>

        </section>

        <section class="sections setting " id="setting">
            <div class="headingSet">
              <h4 class="navSet active" onclick="changeSet('rename')">Edit Admin</h4>
              <h4 class="navSet" onclick="changeSet('delete')">Delete Admin</h4>
              <h4 class="navSet" onclick="changeSet('selectAll')">All Admin lists <span>
                                                                                    <?php
                                                                                      require '../connection.php';
                                                                                      // Fetch the number of rows
                                                                                      $resultA = mysqli_query($conn, "SELECT COUNT(*) as count FROM itadmintable WHERE fullname!=''");
                                                                                      $rowCountA = mysqli_fetch_assoc($resultA)['count'];

                                                                                      // Close the database connection
                                                                                      mysqli_close($conn);

                                                                                      // Output the row count
                                                                                      echo $rowCountA;
                                                                                    ?>
                                                                                  </span>
              </h4>
            </div>
            <div class="setLists rename activeSet" id="rename">
                  <h3>Rename Admin</h3>
              <form action="./itAdminRename.php" method="POST">
                  <div class="previousFullname">
                    <label for="previousFullname">Enter Previous Fullname :</label>
                    <input type="text" id="previousFullname" name="previousFullname" required>
                  </div>
                  <div class="previousPassword">
                    <label for="previousPassword">Enter Previous Password :</label>
                    <input type="text" id="previousPassword" name="previousPassword" required>
                  </div>
                  <div class="newFullname">
                    <label for="newFullname">Enter New Fullname : </label>
                    <input type="text" id="newFullname" name="newFullname" required>
                  </div>
                  <div class="setUser">
                    <label for="setUsername">Enter New Username : </label>
                    <input type="text" id="setUsername" name="setUsername" required>
                  </div>
                  <div class="setPassword">
                    <label for="setPassword">Enter New Password : </label>
                    <input type="password" id="setPassword" name="setPassword" required>
                  </div>
                  <div class="seCpassword">
                    <label for="seCpassword">Confirm Your Password : </label>
                    <input type="password" id="seCpassword" name="seCpassword" required>
                  </div>
                  <div class="setButton">
                    <button type="submit">Rename</button>
                    <button type="reset">Reset</button>
                  </div>
              </form>
             </div>
            <div class="setLists delete" id="delete">
              <h3>Delete Admin</h3>
              <form action="./itAdminDelete.php" method="POST">
                <div class="deleteName">
                  <label for="deleteFullname">Enter Fullname :</label>
                  <input type="text" id="deleteFullname" name="deleteFullname" required>
                </div>
                <div class="deletePassword">
                  <label for="deletePassword">Enter Password :</label>
                  <input type="password" id="deletePassword" name="deletePassword" required>
                </div>
                <div class="deleteBtn">
                  <button type="submit">Delete</button>
                </div>
              </form>
            </div>
            <div class="setLists selectAll" id="selectAll">
            <h3>List of Admins</h3>
            <table class="selectTable">
                <?php
                  require '../connection.php';
                  $i = 1;
                  // Fetch data from admintable
                  $selectRows = mysqli_query($conn, "SELECT * FROM itadmintable WHERE fullname!=''");

                  // Check if there are any rows returned
                  if(mysqli_num_rows($selectRows) > 0) :
                ?>
                    <tr>
                      <th class="Cnumber">#</th>
                      <th class="Cfullname">Fullname</th>
                      <th class="Cusername">Username</th>
                    </tr>
                    <!-- Loop through the fetched rows -->
                    <?php while ($row = mysqli_fetch_assoc($selectRows)) : ?>
                    <tr>
                      <td class="Sno"><?php echo $i++; ?></td>
                      <td class="Snm"><?php echo htmlspecialchars($row["fullname"], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td class="Sun"><?php echo htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                      <td colspan="3">No admins found.</td>
                    </tr>
                <?php endif; ?>
            </table>
            </div>
        </section>
    <?php else: ?>
        <section>
            <h1>Unauthorized</h1>
            <p>You do not have permission to access this page.</p>
        </section>
    <?php endif; ?>
    <footer class="footer">
    <div class="last-footer">
          <div class="heading">
            <p>Copyright &copy; 2024 HU-Students | All Rights Reserved.</p>
          </div>
          <div class="icon">
            <a href="#"><i class='bx bx-up-arrow-alt'></i></a>
          </div>
        </div>
    </footer>
    <div class="style-switch">
      <div class="style-switch-toggler s-icon">
        <i class="bx bx-cog"></i>
      </div>
      <div class="day-night s-icon">
        <i class="bx"></i>
      </div>
      <h4>Theme Colors</h4>
      <div class="colors">
        <span class="color-1" onclick="setActiveStyle('color-1')"></span>
        <span class="color-2" onclick="setActiveStyle('color-2')"></span>
        <span class="color-3" onclick="setActiveStyle('color-3')"></span>
        <span class="color-4" onclick="setActiveStyle('color-4')"></span>
        <span class="color-5" onclick="setActiveStyle('color-5')"></span>
      </div>
    </div>

    <script src="../switcher.js"></script>
    <script src="./sender.js"></script>
    <script src="./recordOffice.js"></script>
</body>
</html>