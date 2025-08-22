<!--8ms01-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BuildMasterPC | Admin - Search about product</title>
  <link rel="icon" type="image/x-icon" href="/../../Image/LOGO.png">
  <link rel="stylesheet" href="../../css/Design.css">
  <link rel="stylesheet" href="../../css/Parts_Page.css">
  <link rel="stylesheet" href="../../css/modify_product.css">
</head>

<header>
  <a href="./Admin_Dashboard_Add.php"> <img class="logo" src="../../Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%"
      height="20%"> </a>

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
        <a href="./Admin_Dashboard_Search.php"> <img class="selected" src="../../Image/icons8-search-50.png"
            alt="Search icon" height="30px" width="30px"> </a>
      </li>
      <li>
        <a href="./Admin_Dashboard_Add.php"> <img src="../../Image/add.png" alt="add icon" height="30" width="30px">
        </a>
      </li>
      <li>
        <a href="./Admin_Dashboard_modify1.php"> <img src="../../Image/modify.png" alt="modify icon" height="30px"
            width="30px"> </a>
      </li>
      <li>
        <a href="./Admin_Dashboard_delete.php"> <img src="../../Image/delete.png" alt="delete icon" height="30px"
            width="30px"> </a>
      </li>
      <li>
        <a href="../../Index.php"> <img src="../../Image/logout.png" alt="logout icon" height="30px" width="30px"> </a>
      </li>
    </ul>
  </nav>
</header>

<body>

  <?php
  // Database configuration
  $host = 'localhost:3307:3307';
  $username = 'root';
  $password = '';
  $database = 'build_master_pc';

  // Create database connection
  $database = mysqli_connect($host, $username, $password, $database);

  // Check if connection was successful
  if (!$database) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Check if 'ProductID' key exists in the POST data
  if (isset($_POST['ProductID'])) {
    $id = $_POST['ProductID'];

    // Retrieve Data From Product Table
    $sql = "SELECT * FROM product WHERE ProductID=" . (string) $id;
    $result1 = mysqli_query($database, $sql);

    // Close the connection
  
    $row = mysqli_fetch_assoc($result1);
    $id = $row['ProductID'];
    $name = $row['Pro_Name'];
    $price = $row['Price'];
    $stock = $row['Quantity'];
    //$description = $row['productDescription'];
    $picture = $row['picture'];
    $category = $row['product_type'];
    // Rest of your code...
  
    $sql = "SELECT * FROM specifications WHERE Product_ProductID=" . (string) $id;
    $result1 = mysqli_query($database, $sql);

    // Close the connection
    mysqli_close($database);



    // Rest of your code...
  
  } else {
    echo "ProductID is not set in the POST data.";
  }
  ?>

  <!--My code starts here-->
  <div class="container mt-5 mb-5">
    <div class="d-flex justify-content-center row">
      <div class="col-lg-6 col-md-8 col-sm-10 pb-5">
        <h4 class="text-center">Modify Products Here</h4>
        <div class="card">
          <div class="card-body">

            <script>

              function showAlert() {
                alert("product updated successfully!");
              }
              function validateForm() {
                var name = document.forms["modifyProduct"]["Pro_Name"].value;
                var picture = document.forms["modifyProduct"]["picture"].value;
                var stock = document.forms["modifyProduct"]["Quantity"].value;
                var price = document.forms["modifyProduct"]["Price"].value;
                //   var description = document.forms["modifyProduct"]["description"].value;
                var category = document.forms["modifyProduct"]["product_type"].value;

                if (name == "") {
                  alert("Name must be filled out");
                  return false;
                }
                //if ( picture == "") {
                //alert("Picture must be selected");
                //return false;
                //}
                if (stock == "") {
                  alert("Stock must be filled out");
                  return false;
                }
                if (isNaN(stock) || stock < 0) {
                  alert("Stock must be a number greater than or equal to 0");
                  return false;
                }
                if (price == "") {
                  alert("Price must be filled out");
                  return false;
                }
                if (price < 0) {
                  alert("Price must be greater than or equal to 0");
                  return false;
                }
                if (description == "") {
                  alert("Description must be filled out");
                  return false;
                }
                if (!/^[a-zA-Z]+$/.test(category)) {
                  alert("Category must contain only alphabetic characters");
                  return false;
                }
                return true;
              }
            </script>

            <form action="modify4.php" method="post" enctype="multipart/form-data" name="modifyProduct"
              onsubmit="return validateForm()">
              <div class="form-group mb-3">
                <label>Name:</label>
                <input type="text" name="Pro_Name" class="form-control" value="<?php echo $name ?>">

              </div>
              <div class="form-group mb-3">
                <label>Image:</label>
                <input type="file" name="picture" class="form-control">
              </div>
              <!--
                  <div class="form-group mb-3">
                    <label>Image:</label>
                    <input type="file" name="picture" class="form-control" value="assets/<?php echo $row['picture']; ?>">
                  </div>
                   -->
              <div class="form-group mb-3">
                <label>Stock:</label>
                <input type="number" name="Quantity" class="form-control" value="<?php echo $stock ?>">
              </div>
              <div class="form-group mb-3">
                <label>Price:</label>
                <input type="text" name="Price" class="form-control" value="<?php echo $price ?>"
                  placeholder="eg: 99.99">
              </div>

              <div class="form-group mb-3">

                <label>Category:</label>
                <select name="product_type" class="form-control">
                  <option value="PC" <?php if ($category == "PC")
                    echo "selected"; ?>>PC</option>
                  <option value="Accessory" <?php if ($category == "Accessory")
                    echo "selected"; ?>>Accessory</option>
                  <option value="CPU" <?php if ($category == "CPU")
                    echo "selected"; ?>>CPU</option>
                  <option value="Motherboard" <?php if ($category == "Motherboard")
                    echo "selected"; ?>>Motherboard
                  </option>
                  <option value="CPU fan" <?php if ($category == "CPU fan")
                    echo "selected"; ?>>CPU fan</option>
                  <option value="CPU cooling" <?php if ($category == "CPU cooling")
                    echo "selected"; ?>>CPU cooling
                  </option>
                  <option value="GPU" <?php if ($category == "GPU")
                    echo "selected"; ?>>GPU</option>
                  <option value="RAM" <?php if ($category == "RAM")
                    echo "selected"; ?>>RAM</option>
                  <option value="HDD" <?php if ($category == "HDD")
                    echo "selected"; ?>>HDD</option>
                  <option value="SSD" <?php if ($category == "SSD")
                    echo "selected"; ?>>SSD</option>
                  <option value="M.2" <?php if ($category == "M.2")
                    echo "selected"; ?>>M.2</option>
                  <option value="Power supply" <?php if ($category == "Power supply")
                    echo "selected"; ?>>Power supply
                  </option>
                  <option value="Case" <?php if ($category == "Case")
                    echo "selected"; ?>>Case</option>
                </select>
              </div>
              <?php
              while ($row = mysqli_fetch_assoc($result1)) {
                $Specification_Name = $row['Speci_Name'];
                $Specification_Value = $row['Speci_value'];
                //$description = $row['productDescription'];
                ?>
                <div class="form-group mb-3">
                  <label>Specification Name:</label>
                  <input type="text" name="Specification_Name[]" class="form-control"
                    value="<?php echo $Specification_Name ?>">
                </div>
                <div class="form-group mb-3">
                  <label>Specification Value:</label>
                  <input type="text" name="Specification_valuee[]" class="form-control"
                    value="<?php echo $Specification_Value ?>">
                </div>
              <?php } ?>
              <div class="text-center">
                <input type="hidden" id="ProductID" name="ProductID" value="<?php echo $id ?>">
                <button class="btn btn-success" id="modify" name="modify" onclick="showAlert()">Modify Product</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--my code ends here-->
  <?php
  // Page footer
  //  include_once 'include/footer.php';
  ?>
</body>

<?php
try {
  // Connect to the database
  if (!($database = mysqli_connect('localhost:3307:3307', 'root', ''))) {
    throw new Exception("Failed to connect to the database");
  }

  // Select the database
  if (!mysqli_select_db($database, 'build_master_pc')) {
    throw new Exception("Failed to select the database");
    exit;
  }

  // Check if form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve product information from the form
    $productName = $_POST['product_name'] ?? '';
    $productPrice = $_POST['product_price'] ?? '';
    $productQuantity = $_POST['product_quantity'] ?? '';
    $productType = $_POST['product_type'] ?? '';
    $productImageBase64 = $_POST['product_image'] ?? '';

    // Validate input data (add more validation as needed)
    if (empty($productName) || empty($productPrice) || empty($productQuantity) || empty($productType) || empty($productImageBase64)) {
      throw new Exception("All product details are required");
    }

    // Decode base64 encoded image data
    $imageData = base64_decode($productImageBase64);

    // Generate a unique file name
    $imageName = uniqid() . '.jpg';

    // Save the image to the file system (uncomment this line when ready)
    // file_put_contents('product_images/' . $imageName, $imageData);

    // Insert new product into the database
    $query = "INSERT INTO product (Pro_Name, Price, Quantity, product_type, picture) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($database, $query);
    mysqli_stmt_bind_param($stmt, "ssiss", $productName, $productPrice, $productQuantity, $productType, $imageName);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      // Redirect to the product add page
      header("Location: Admin_Dashboard_Add.php");
      exit;
    } else {
      throw new Exception("Failed to insert product into the database");
    }
  }
} catch (Exception $e) {
  // error_log("Error: " . $e->getMessage());
  // echo "An error occurred: " . $e->getMessage();
}
?>



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