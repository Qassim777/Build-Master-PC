<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BuildMasterPC | Admin - Delete Product</title>
  <link rel="icon" type="image/x-icon" href="/../../Image/LOGO.png">
  <link rel="stylesheet" href="../../css/Design.css">
  <link rel="stylesheet" href="../../css/swiper-bundle.min.css">
  <link rel="stylesheet" href="../../css/PC_Part.css" />
  <link rel="stylesheet" href="../../css/Parts_Page.css">
  <link rel="stylesheet" href="../../css/PC_details.css">
</head>

<body>

  <header>
    <a href="./Admin_Dashboard_Add.php">
      <img class="logo" src="../../Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%" height="20%">
    </a>

    <nav class="nav_links">
      <ul>
        <li>Admin Dashboard</li>
      </ul>
    </nav>

    <nav>
      <ul class="nav_links">
        <li><a href="./Admin_Dashboard_Search.php"><img src="../../Image/icons8-search-50.png" alt="Search icon"
              height="30px" width="30px"></a></li>
        <li><a href="./Admin_Dashboard_Add.php"><img src="../../Image/add.png" alt="add icon" height="30"
              width="30px"></a></li>
        <li><a href="./Admin_Dashboard_modify1.php"><img src="../../Image/modify.png" alt="modify icon" height="30px"
              width="30px"></a></li>
        <li><a href="./Admin_Dashboard_delete.php"><img class="selected" src="../../Image/delete.png" alt="delete icon"
              height="30px" width="30px"></a></li>
        <li><a href="../../Index.php"><img src="../../Image/logout.png" alt="logout icon" height="30px"
              width="30px"></a></li>
      </ul>
    </nav>
  </header>

  <form action="./Admin_Dashboard_delete.php" method="get">
    <div class="cart" style="display: flex; justify-content: center; align-items: center;">
      <input class="text_input" type="text" name="search" placeholder="Enter the product name to search"
        style="margin-right: 20px; width: 70%;">
      <button class="update-image" type="submit">Search</button>
    </div>
  </form>

  <?php
  try {
    // Connect to the database
    $database = mysqli_connect('localhost:3307:3307', 'root', '');
    if (!$database) {
      throw new Exception("Failed to connect to the database");
    }

    // Select the database
    if (!mysqli_select_db($database, 'build_master_pc')) {
      throw new Exception("Failed to select the database");
    }

    // Retrieve search term
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Check if search term is set
    if (!empty($searchTerm)) {
      // Query to retrieve products matching the search term
      $searchQuery = "SELECT * FROM product WHERE Pro_Name LIKE '%" . mysqli_real_escape_string($database, $searchTerm) . "%'";
      $searchResult = mysqli_query($database, $searchQuery);

      // Verify the search result
      if (!$searchResult) {
        throw new Exception("Query execution error: " . mysqli_error($database));
      }

      // Display search result
      if (mysqli_num_rows($searchResult) == 0) {
        echo "No products found.";
      } else {
        echo '<div class="container">';
        while ($row = mysqli_fetch_assoc($searchResult)) {
          echo '<div class="pc-container">';
          echo '<a href="#">';
          echo '<div class="img-continer">';
          echo '<img src="./image/' . $row['picture'] . '" class="pc-img">';
          echo '</div>';
          echo '<h3 class="pc-info">' . $row['Pro_Name'] . '</h3>';
          echo '<div class="pc-status-in">In stock</div>';
          echo '</a>';
          echo '<hr>';
          echo '<div>';
          echo '<h5 class="pc-payment">Price</h5>';
          echo '<h4 class="pc-payment">' . $row['Price'] . ' SR</h4>';
          echo '</div>';
          echo '<div class="VAT">VAT not included</div>';
          echo '<div class="cart">';
          echo ' <form action="delete_product.php" method="post" onsubmit="return confirmDelete(event)">';
          echo '<input type="hidden" name="product_id" value="' . $row['ProductID'] . '">';
          echo '<button type="submit" class="cart-button" name="delete_product"><img class="shopping-cart-img" alt="delete product icon" src="../../Image/delete product.png"></button>';
          echo '</form>';
          echo '</div>';
          echo '</div>';
        }
        echo '</div>';
      }
    }
  } catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo "An error occurred.";
  }
  ?>

  <script>
    function confirmDelete(event) {
      if (confirm("Are you sure you want to delete this product?")) {
        return true; // Proceed with form submission
      } else {
        event.preventDefault(); // Cancel form submission
        return false;
      }
    }
  </script>

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