<?php
session_start();
// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['First_Name']);
}

// Retrieve error parameter to display error messages
$loginError = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php if (isLoggedIn()) : ?>
<!--8ms01-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildMasterPC | Admin - modify product</title>
    <link rel="icon" type="image/x-icon" href="/../../Image/LOGO.png">
    <link rel="stylesheet" href="../../css/Design.css">
    <link rel="stylesheet" href="../../css/swiper-bundle.min.css">
    <link rel="stylesheet" href="../../css/PC_Part.css"/>
    <link rel="stylesheet" href="../../css/Parts_Page.css">
</head>


<header>
  <a href="./Admin_Dashboard_Add.php" >  <img class="logo" src="../../Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%" height="20%"> </a>

  <nav class="nav_links">
      <ul>
          <li>
            Admin Dashboard
          </li>
      </ul>
  </nav>

  <nav>
      <ul class="nav_links">
            <li>
                <a href="./Admin_Dashboard_Search.php"> <img src="../../Image/icons8-search-50.png" alt="Search icon" height="30px"  width="30px"> </a>
            </li>
          <li>
              <a href="./Admin_Dashboard_Add.php"> <img src="../../Image/add.png" alt="add icon" height="30"  width="30px" > </a>
          </li>
          <li>
              <a href="./Admin_Dashboard_modify1.php"> <img class="selected" src="../../Image/modify.png" alt="modify icon" height="30px"  width="30px"> </a>
          </li>
          <li>
              <a href="./Admin_Dashboard_delete.php"> <img src="../../Image/delete.png" alt="delete icon" height="30px" width="30px" > </a>
          </li>
          <li>
            <a href="../../Index.php"> <img src="../../Image/logout.png" alt="logout icon" height="30px" width="30px" > </a>
        </li>
      </ul>
  </nav>
</header>

<body>
  <div class="container">
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=PC">
            <div class="img-container">
                <img src="../../Image/PC.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">PC</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=Motherboard">
            <div class="img-container">
                <img src="../../Image/motherboard.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">Motherboard</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=CPU">
          <div class="img-container">
                <img src="../../Image/CPU.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">CPU</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=CPU Fan">
          <div class="img-container">
                <img src="../../Image/CPU_Fan.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">CPU Fan</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=CPU Cooling">
          <div class="img-container">
                <img src="../../Image/CPU_Cooling.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">CPU Cooling</h3>
        </a>
    </div>
    <div class="component-container">
       <a href="./Admin_Dashboard_modify2.php?category=GPU">
          <div class="img-container">
                <img src="../../Image/GPU.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">GPU</h3>
        </a>
    </div>
    <div class="component-container">
       <a href="./Admin_Dashboard_modify2.php?category=RAM">
          <div class="img-container">
                <img src="../../Image/RAM.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">RAM</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=HDD">
          <div class="img-container">
                <img src="../../Image/HDD.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">HDD</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=SSD">
          <div class="img-container">
                <img src="../../Image/SSD.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">SSD</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=M.2">
          <div class="img-container">
                <img src="../../Image/M2.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">M.2</h3>
        </a>
    </div>
    <div class="component-container">
        <a href="./Admin_Dashboard_modify2.php?category=Power Supply">
          <div class="img-container">
                <img src="../../Image/Power_Supply.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">Power Supply</h3>
        </a>
    </div>
    <div class="component-container">
       <a href="./Admin_Dashboard_modify2.php?category=Cases">
          <div class="img-container">
                <img src="../../Image/Case.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">Cases</h3>
        </a>
    </div>
    
    <div class="component-container">
       <a href="./Admin_Dashboard_modify2.php?category=Accessory">
          <div class="img-container">
                <img src="../../Image/accessories.png" alt="Component Image" class="component-img" />
            </div>
            <h3 class="component-info">Accessory</h3>
        </a>
    </div>
</div>
</body>

<footer class="footer">
    <div class="footer__addr">
      <h1 class="footer__logo" style="padding-bottom: 0px;">
        <img class="logo" src="../../Image/LOGO.png" alt="BUILDMASTERPC logo" width="10%" height="10%">
      </h1>

      <h2>Support</h2>

      <address>
        IAU - Al Khobar - Saudi Arabia<br>

        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d228791.7317672436!2d49.992540180581884!3d26.36304025059799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ef85c961edaf%3A0x7b2db98f2941c78c!2sImam%20Abdulrahman%20Bin%20Faisal%20University!5e0!3m2!1sen!2ssa!4v1672229820933!5m2!1sen!2ssa"
          width="200" height="100" style="border: 0" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>

        <a class="footer__btn" href="#">Customer Service</a>
        <a class="footer__btn" href="../Contact_Us.php">Contact Us</a>
      </address>
    </div>

    <ul class="footer__nav">
      <li class="nav__item">
        <h2 class="nav__title">COMPANY</h2>

        <ul class="nav__ul">
          <li>
            <a href="#">About Us</a>
          </li>

          <li>
            <a href="#">Terms & Conditions</a>
          </li>

          <li>
            <a href="#">Warranty Policy</a>
          </li>
          <li>
            <a href="#">Return Policy</a>
          </li>

          <li>
            <a href="#">Shipping Policy</a>
          </li>

          <li>
            <a href="#">VAT Registration Number</a>
          </li>
        </ul>
      </li>

      <li class="nav__item">
        <h2 class="nav__title">PRODUCT</h2>

        <ul class="nav__ul">
          <li>
            <a href="./Admin_Dashboard_modify2.php?category=PC">PC's</a>
          </li>

          <li>
            <a href="./Admin_Dashboard_modify1.php">Pc Parts</a>
          </li>

          <li>
            <a href="./Admin_Dashboard_modify2.php?category=Accessory">Accessories</a>
          </li>
        </ul>
      </li>

      <li class="nav__item">
        <h2 class="nav__title">We Accept Payment Via</h2>

        <ul class="nav__ul">
          <li>
            <img src="../../Image/mada.png" alt="mada" width="25%">
          </li>

          <li>
            <img src="../../Image/visa.png" alt="visa" width="25%">
          </li>

          <li>
            <img src="../../Image/master.png" alt="master" width="25%">
          </li>
        </ul>
      </li>
    </ul>

    <div class="legal">
      <p>&copy; 2024 BUILDMASTERPC. All rights reserved.</p>

      <div class="legal__links">
        <a href="">
          <img src="../../Image/whatsapp.png" alt="Whatsapp" width="40%">
        </a>
        <a href="">
          <img src="../../Image/linkedin.png" alt="linkedin" width="40%">
        </a>
        <a href="">
          <img src="../../Image/x.png" alt="X" width="40%">
        </a>
      </div>
    </div>
  </footer>


</html>
<?php else : ?>
  <?php header('Location: ../../Index.php'); exit; ?>
<?php endif; ?>
