<?php
session_start();

function isLoggedIn()
{
  return isset($_SESSION['First_Name']);
}

// Retrieve error parameter to display error messages
$loginError = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php if (isLoggedIn()): ?>
  <?php
  $database = mysqli_connect('localhost:3307:3307', 'root', '', 'build_master_pc');
  if (!$database) {
    throw new Exception("Failed to connect to the database");
  }
  $info = '';
  if (isset($_REQUEST['add'])) {
    $name = $_REQUEST['name'];
    $price = $_REQUEST['price'];
    $stock = $_REQUEST['stock'];
    $category = $_REQUEST['type'];
    $spec_names = $_REQUEST['spec_name']; // Specification names array
    $spec_values = $_REQUEST['spec_value']; // Specification values array

    $target_dir = 'image/';
    $temp = $_FILES['picture']['tmp_name'];
    $uniq = time() . rand(1000, 9999);
    $info = pathinfo($_FILES['picture']['name']);

    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allow certain file formats
    if ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "jpeg") {
      $info = '<div class="alert mt-4 alert-danger"  role="alert">Sorry only jpg, png and jpeg formats are allowed!</div>';
    } else {
      $file_name = "file_" . $uniq . "." . $info['extension']; //with your created name
      move_uploaded_file($temp, $target_dir . $file_name);

      $sql2 = "INSERT INTO product (Pro_name,picture,Quantity,price,product_type) VALUES ('$name','$file_name','$stock','$price','$category')";

      if (mysqli_query($database, $sql2)) {
        // Get the inserted product's ID
        // Insert specifications
        $productId = mysqli_insert_id($database);

        // Insert specifications into the database
        $spec_names = $_REQUEST['spec_name'];
        $spec_values = $_REQUEST['spec_value'];
        foreach ($spec_names as $key => $spec_name) {
          $spec_name = mysqli_real_escape_string($database, $spec_name);
          $spec_value = mysqli_real_escape_string($database, $spec_values[$key]);
          $sql_spec = "INSERT INTO specifications (Product_ProductID, Speci_Name, Speci_value) VALUES (?, ?, ?)";
          $stmt_spec = mysqli_prepare($database, $sql_spec);
          mysqli_stmt_bind_param($stmt_spec, "iss", $productId, $spec_name, $spec_value);
          mysqli_stmt_execute($stmt_spec);
        }
        $info = '<div class="alert alert-success">Product added!</div>';
      } else {
        $info = '<div class="alert alert-danger">An error occurred!</div>';
      }
    }
    header('Location: Admin_Dashboard_Add.php');
    exit;
  }
?>
<?php else: ?>
  <?php header('Location: ../../Index.php');
  exit; ?>
<?php endif; ?>