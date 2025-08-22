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


<?php if (isLoggedIn()): ?>
  <!--8ms01-->
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildMasterPC | Admin - Search about product</title>
    <link rel="icon" type="image/x-icon" href="/../../Image/LOGO.png">
    <link rel="stylesheet" href="../../css/Design.css">
    <link rel="stylesheet" href="../../css/add_product.css">
  </head>

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
      $productspeci = $_POST['Speci_ID'] ?? '';
      $productspecivalue = $_POST['Speci_value'] ?? '';

      // Validate input data (add more validation as needed)
      if (empty($productName) || empty($productPrice) || empty($productQuantity) || empty($productType) || empty($productImageBase64) || empty($productspeci) || empty($productSpecivalue) || empty($productspecivalue)) {
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
        $productId = mysqli_insert_id($database);

        // Insert specifications into the database

        // Redirect to the product add page
        header("Location: Admin_Dashboard_Add.php");
        exit;
      } else {
        throw new Exception("Failed to insert product into the database");
      }

    }
  } catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo "An error occurred: " . $e->getMessage();
  }
  ?>
  <header>
    <a href=""> <img class="logo" src="../../Image/LOGO.png" alt="BUILDMASTERPC logo" width="20%" height="20%"> </a>

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
          <a href="./Admin_Dashboard_Search.php"> <img src="../../Image/icons8-search-50.png" alt="Search icon"
              height="30px" width="30px"> </a>
        </li>
        <li>
          <a href="./Admin_Dashboard_Add.php"> <img class="selected" src="../../Image/add.png" alt="add icon" height="30"
              width="30px"> </a>
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
    <script>

      function showAlert() {
        alert("product added successfully!");
      }

      function validateForm() {

        var picture = document.forms["Add_mock"]["picture"].value;
        var price = document.forms["Add_mock"]["price"].value;
        var stock = document.forms["Add_mock"]["stock"].value;
        var name = document.forms["Add_mock"]["name"].value;
        var type = document.forms["Add_mock"]["type"].value;


        if (picture == "") {
          alert("Picture must be selected");
          return false;
        }
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
        if (name == "") {
          alert("name must be filled out");
          return false;
        }
        if (!/^[a-zA-Z]+$/.test(category)) {
          alert("Category must contain only alphabetic characters");
          return false;
        }
        return true;
      }

      function addSpecification() {
        const specContainer = document.getElementById('spec-container');
        const specName = specContainer.firstElementChild.cloneNode(true);
        const specVlaue = specContainer.lastElementChild.cloneNode(true)


        specContainer.appendChild(specName);
        specContainer.appendChild(specVlaue);
      }


    </script>


    <form action="add_product.php" method="post" enctype="multipart/form-data" name="Admin_Dashboard_Add.php"
      onsubmit="return validateForm()">
      <div class="form-group">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required>
      </div>

      <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required>
      </div>

      <div class="form-group">
        <label for="stock">Quantity:</label>
        <input type="number" name="stock" id="stock" required>
      </div>

      <div class="form-group">
        <label for="type">Product Type:</label>
        <select name="type" id="type" required>
          <option value="PC">PC</option>
          <option value="Accessory">Accessory</option>
          <option value="CPU">CPU</option>
          <option value="Motherboard">Motherboard</option>
          <option value="CPU fan">CPU fan</option>
          <option value="CPU cooling">CPU cooling</option>
          <option value="GPU">GPU</option>
          <option value="RAM">RAM</option>
          <option value="HDD">HDD</option>
          <option value="SSD">SSD</option>
          <option value="M.2">M.2</option>
          <option value="Power supply">Power supply</option>
          <option value="case">Case</option>
        </select>
      </div>

      <div class="form-group">
        <input type="file" name="picture" id="picture" accept="image/*" required>

      </div>

      <div id="spec-container">
        <div class="form-group">
          <label for="spec_name[]">Specification Name:</label>
          <input type="text" name="spec_name[]" class="spec_name" required>
        </div>
        <div class="form-group">
          <label for="spec_value[]">Specification Value:</label>
          <input type="text" name="spec_value[]" class="spec_value" required>
        </div>
      </div>

      <button type="button" onclick="addSpecification()">Add Specification</button>

      <button type="btn btn-success" name="add" onclick="showAlert()">Add Product</button>
    </form>

    <!-- <script>
        const productImageUpload = document.getElementById('product_image_upload');
        const productImage = document.getElementById('product_image');

        productImageUpload.addEventListener('change', function() {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                productImage.value = e.target.result;
            }

            reader.readAsDataURL(file);
        });
    </script> -->
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
<?php else: ?>
  <?php header('Location: ../../Index.php');
  exit; ?>
<?php endif; ?>