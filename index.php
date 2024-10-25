<?php
    include 'connection.php';
    if (isset($_POST['login'])) {
      header("Location: distribute.php");
      exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Record Management System</title>
  </head>
  <link rel="stylesheet" href="./index.css">
  <link rel="stylesheet" href="./switcher.css" />
  <link rel="stylesheet" href="./color-1.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="./color-1.css" class="alternate-style" title="color-1" disabled/>
  <link rel="stylesheet" href="./color-2.css" class="alternate-style" title="color-2" disabled/>
  <link
    rel="stylesheet"
    href="./color-3.css"
    class="alternate-style"
    title="color-3"
    disabled
  />
  <link
    rel="stylesheet"
    href="./color-4.css"
    class="alternate-style"
    title="color-4"
    disabled
  />
  <link
    rel="stylesheet"
    href="./color-5.css"
    class="alternate-style"
    title="color-5"
    disabled
  />

  <body>
    <!-- header start -->
    <header class="header">
      <div class="logo">
        <img
          src="./logo/Ministry_of_Innovation_and_Technology_Ethiopia_removebg_preview.png"
          alt=""
          width="60px"
        />
      </div>
      <div class="bx bx-menu bx-tada" id="menu-icon"></div>
      <nav class="nav">
        <a href="#home" class="navbar active activeBar" onclick="openSection('home')"><i class='bx bxs-home'></i>Home</a>
        <a href="#send-message"  class="navbar" onclick="openSection('send-message')"><i class='bx bxs-message bx-tada'></i>Send Message</a>
        <a href="#login" class="navbar"  onclick="openSection('login')"><i class='bx bx-log-in'></i>Login</a>
        <a href="./Dashboard.html" class="navbar hidden"  onclick="openSection('about')"><i class='bx bxs-user'></i>About Us</a>
      </nav>
    </header>
    <!-- header end -->
    <!-- home section start -->
    <section class="displaysections home activeSection" id="home">
      <div class="container">
        <div class="title">
          <h2>MinT</h2>
          <p>
            Ministry of Innovation and Technology
          </p>
        </div>
      </div>
        <!-- first list -->
      <div class="home-lists padd-30">
         <div class="lists-item padd-15">
            <div class="list-title">
              <h2>
                 Ministry of Innovation and Technology
              </h2>
              <p>
                Mint is an Ethiopian government department responsible for science and technological development in Ethiopia as well as a governing body of communications. It was established as a commission in December 1975 by directive No.62/1975. The current minister is Belete Molla since 2021.
              </p>
              <div class="buttons glow">
                <a href="#"><h3>Read More</h3></a>
              </div>
            </div>
         </div>
         <div class="lists-image">
            <div class="image-lists">
                <img src="./Image/20240727_225844_4595.png" alt="">
            </div>
         </div>
      </div>

       <!-- second list -->
       <div class="second">
       <div class="home-lists padd-30">
        <div class="lists-image">
          <div class="image-lists">
              <img src="./Image/20240727_225816_6144.png" alt="">
          </div>
       </div>
        <div class="lists-item padd-15 ">
           <div class="list-title">
             <h2>
              History
             </h2>
             <p>The Ministry of Science and Technology (MoST) was a governmental institution that was 
              established for the first time in December 1975 by proclamation 
              No.62/1975 as a commission. Following the change in government in 
              1991 and with the issuance of the new economic policy, the commission was 
              re-established in March 1994 by Proclamation No.91/94. The commission went 
              into its third phase of re-institution on 24 August 1995 by Proclamation No.7/1995, 
              as an agency following the establishment of the Federal Democratic Republic of Ethiopia .
            </p>
             <div class="buttons glow">
               <a href="#"><h3>Read More</h3></a>
             </div>
           </div>
        </div>
     </div>
    </div>
       <!-- third list -->
      <div class="home-lists padd-30">
        <div class="lists-item padd-15">
           <div class="list-title">
             <h2>
              Vision
             </h2>
             <p>
              To see Ethiopia entrench the capacities which enable rapid learning, adaptation and utilization of effective foreign technologies by the year 2023/24.
              It has a mission of coordinating, encouraging and supporting science and technology activities that realize the country's social and economic developments
             </p>
             <div class="buttons glow">
               <a href="#"><h3>Read More</h3></a>
             </div>
           </div>
        </div>
        <div class="lists-image">
           <div class="image-lists">
               <img src="./Image/360_F_239520607_abB3AakIrZozIAPgdVAMiMArLwi0uJTL.jpg" alt="">
           </div>
        </div>
     </div>
     <!-- <div class="portfolio">
      <h2>Some Gallery</h2>
    </div>
    <div class="frame">
     <div class="animate-image">
      <div class="box">
         <span style="--i:1;"><img src="./Image/20240727_225816_6144.png" alt=""></span>
         <span style="--i:2;"><img src="./Image/20240727_225844_4595.png" alt=""></span>
         <span style="--i:3;"><img src="./Image/20240727_225908_8531.png" alt=""></span>
         <span style="--i:4;"><img src="./Image/1p.png" alt=""></span>
         <span style="--i:5;"><img src="./Image/2p.png" alt=""></span>
         <span style="--i:6;"><img src="./Image/3p.png" alt=""></span>
         <span style="--i:7;"><img src="./Image/20240727_225816_6144.png" alt=""></span>
         <span style="--i:8;"><img src="./Image/20240727_225908_8531.png" alt=""></span>
      </div>
     </div>
    </div> -->
    </section>
    <!-- home section end -->
    <!-- section send message start -->
    <section class="displaysections send-message" id="send-message">
      <div class="container">
          <div class="heading">
            <h1>Welcome To <Span>Letter Section</Span></h1>
          </div>

          <div class="tab-titles">
            <p class="tab-links activelink" onclick="opentab('skills')">Upload Image</p>
            <p class="tab-links" onclick="opentab('exprience')">Type Letter</p>
          </div>
          <div class="tab-contents activetab" id="skills">
          <div class="uploaded">
            <form action="./indexUploadMessage.php" name="myForm" method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return validateForms(event)">
              <div class="image">
                <label>Upload Your Image:</label>
                <input type="file" name="imageUploaded" id="imageUploaded" accept=".jpg, .jpeg, .png">
              </div>
              <div class="email">
                <label for="emailAddress">Email Address:</label>
                <input type="email" id="emailAddress" name="emailAddress" placeholder="ex..me@gmail.com">
              </div>
              <div class="mobile">
                <label for="mobileNum">Phone Number:</label>
                <input type="number" id="mobileNum" name="mobileNum" placeholder="ex..0912456545">
              </div>
              <div class="divname">
                <label>Description:</label>
                <textarea name="nameLabel" id="nameLabel" required cols="30" rows="10" placeholder="Write your email address or phone number"></textarea>
              </div>
              <div class="submitButton">
                <button type="submit" name="submit-btn">Submit</button>
              </div>
            </form>
          </div>

          </div>
          <div class="tab-contents" id="exprience">
              <div class="typeLetter">
                  <form action="">
                    <div class="form-container">
                      <div class="date">
                          <label for="date">Date : </label>
                          <input type="date" name="date" id="date">
                      </div>
                      <div class="letter">
                          <label for="">Write Letter : </label>
                          <textarea name="letter" id="letter" cols="30" rows="10" required></textarea>
                      </div>
                      <div class="description">
                          <label for="">Description : </label>
                          <input type="text" name="description" id="description" required>
                      </div>
                      <div class="buttons">
                          <button type="submit" name="submitForm">Submit</button>
                          <button type="reset">Reset</button>
                      </div>
                    </div>
                  </form>
                </div>
          </div>
    </section>
    <!-- section send message end -->
    <!-- login section start -->
    <section class="displaysections login" id="login">
      <div class="block glow">
        <div class="login-header">
          <h2 class="">Login</h2>
        </div>
        <form action="./distribute.php" method="post">
          <div class="forms">
            <div class="username">
               <label for="username"><h3>Username :</h3></label>
               <input type="text" id="username" name="username" required>
            </div>
            <div class="password">
               <label for="password"><h3>Password :</h3></label>
               <input type="password" name="password" id="password" required>
            </div>
          </div>
          <div class="btn">
              <button type="reset" class=""><h3>Reset</h3></button>
              <button type="submit" name="login"><h3>Login</h3></button>
          </div>
      </form>
      </div>
      </section>
    <!-- login section end -->
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
    <!-- footer start -->
    <footer class="footer">
      <div class="contact-us">
        <div class="head">
          <h2>Work With Us</h2>
        </div>
        <div class="contact">
          <a href="./contact.html"><h3>Contact Us</h3></a>
        </div>
      </div>
      <div class="footer-items">
          <div class="footer-item-list">
              <div class="department">
                <h2>Some Department We Have</h2>
              </div>
              <div class="list-of-department">
                <ul>
                  <li>Policy and Planning Department</li>
                  <li>Research and Development (R&D) Department</li>
                  <li>Innovation and Entrepreneurship Department</li>
                  <li>Technology Transfer and Commercialization Department</li>
                  <li>ICT Infrastructure Department</li>
                  <li>Data and Analytics Department</li>
                  <li>Funding and Grants Department</li>
                </ul>
              </div>
          </div>
          <div class="footer-second-list">
              <div class="head">
                <h2>Location</h2>
              </div>
              <div class="head-list">
                Ethiopia, Piassa, Thewdros-Squere
              </div>
          </div>
      </div>
        <div class="last-footer">
          <div class="heading">
            <p>Copyright &copy; 2024 HU-Students | All Rights Reserved.</p>
          </div>
          <div class="icon">
            <a href="#"><i class='bx bx-up-arrow-alt'></i></a>
          </div>
        </div>
    </footer>
    <!-- footer end -->
    <!-- java script for switcher -->
    <script src="./switcher.js"></script>
    <script src="./menuIcon.js"></script>
  </body>
</html>
  <!-- php for login section -->

